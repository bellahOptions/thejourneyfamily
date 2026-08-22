<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatRegistration;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

/**
 * Bulk-imports registrations from the original Google Form CSV export
 * (Timestamp, Name, Wedding Anniversary, WhatsApp numbers, transport,
 * children, expectations, prayer request, feedback, payment, questions).
 * That export has no email or package column, so imported rows are saved
 * without them (both are nullable on this table) and flagged in the admin
 * UI for manual follow-up.
 */
class RegistrationImportController extends Controller
{
    /**
     * Column order in the source Google Form export.
     */
    private const COLUMNS = [
        0 => 'timestamp',
        1 => 'couple_name',
        2 => 'anniversary_raw',
        3 => 'participant_whatsapp',
        4 => 'spouse_whatsapp',
        5 => 'transport_raw',
        6 => 'bringing_children_raw',
        7 => 'children_ages',
        8 => 'expectations',
        9 => 'prayer_request',
        10 => 'previous_feedback',
        11 => 'payment_made_raw',
        12 => 'payment_proof_note',
        13 => 'questions',
    ];

    public function create(): View
    {
        return view('admin.registrations.import');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $rows = $this->readCsv($request->file('file')->getRealPath());

        if ($rows === []) {
            return back()->withErrors(['file' => 'That file has no data rows to import.']);
        }

        $imported = 0;
        $duplicates = 0;
        $skipped = [];

        DB::transaction(function () use ($rows, &$imported, &$duplicates, &$skipped) {
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +1 for header row, +1 for 1-based counting

                $data = $this->mapRow($row);

                if (blank($data['couple_name'])) {
                    $skipped[] = "Row {$rowNumber}: missing a name.";

                    continue;
                }

                $anniversary = $this->parseAnniversary($data['anniversary_raw']);

                if ($anniversary === null) {
                    $skipped[] = "Row {$rowNumber} ({$data['couple_name']}): couldn't read a wedding anniversary date.";

                    continue;
                }

                $alreadyExists = RetreatRegistration::query()
                    ->where('couple_name', $data['couple_name'])
                    ->where('participant_whatsapp', $data['participant_whatsapp'])
                    ->exists();

                if ($alreadyExists) {
                    $duplicates++;

                    continue;
                }

                $transport = $this->normalizeTransport($data['transport_raw']);
                $timestamp = $this->parseTimestamp($data['timestamp']) ?? CarbonImmutable::now();

                $registration = new RetreatRegistration([
                    'couple_name' => $data['couple_name'],
                    'email' => null,
                    'anniversary_day' => $anniversary['day'],
                    'anniversary_month' => $anniversary['month'],
                    'participant_whatsapp' => $data['participant_whatsapp'],
                    'spouse_whatsapp' => $data['spouse_whatsapp'],
                    'transport_status' => $transport['status'],
                    'transport_notes' => $transport['notes'],
                    'bringing_children' => $this->normalizeYesNo($data['bringing_children_raw']),
                    'children_ages' => $data['children_ages'] ?: null,
                    'expectations' => $data['expectations'] ?: null,
                    'prayer_request' => $data['prayer_request'] ?: null,
                    'previous_feedback' => $data['previous_feedback'] ?: null,
                    'payment_made' => $this->normalizeYesNo($data['payment_made_raw']),
                    'payment_proof_note' => $data['payment_proof_note'] ?: null,
                    'package_key' => null,
                    'package_label' => null,
                    'package_price' => null,
                    'questions' => $data['questions'] ?: null,
                    'consent_at' => $timestamp,
                ]);

                $registration->confirmation_token = (string) Str::uuid();
                $registration->created_at = $timestamp;
                $registration->updated_at = $timestamp;
                $registration->timestamps = false;
                $registration->save();

                $imported++;
            }
        });

        return redirect()
            ->route('admin.registrations.import')
            ->with('importSummary', [
                'imported' => $imported,
                'duplicates' => $duplicates,
                'skipped' => $skipped,
            ]);
    }

    /**
     * @return list<list<string>>
     */
    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return [];
        }

        $rows = [];
        $isFirstRow = true;

        while (($row = fgetcsv($handle)) !== false) {
            if ($isFirstRow) {
                $isFirstRow = false;

                continue;
            }

            if ($row === [null] || $row === ['']) {
                continue;
            }

            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    /**
     * @param  list<string>  $row
     * @return array<string, string|null>
     */
    private function mapRow(array $row): array
    {
        $data = [];

        foreach (self::COLUMNS as $index => $key) {
            $data[$key] = isset($row[$index]) ? trim((string) $row[$index]) : null;
        }

        return $data;
    }

    /**
     * @return array{day: int, month: int}|null
     */
    private function parseAnniversary(?string $raw): ?array
    {
        if (blank($raw)) {
            return null;
        }

        try {
            $date = CarbonImmutable::parse($raw);
        } catch (Throwable) {
            return null;
        }

        return ['day' => $date->day, 'month' => $date->month];
    }

    private function parseTimestamp(?string $raw): ?CarbonImmutable
    {
        if (blank($raw)) {
            return null;
        }

        // e.g. "2026/06/14 10:10:09 AM GMT+1" — this dataset is always
        // Nigerian submissions, so the literal GMT offset is ignored in
        // favour of the app's configured retreat timezone.
        $cleaned = trim((string) preg_replace('/\s*GMT[+-]\d+\s*$/', '', $raw));

        try {
            return CarbonImmutable::createFromFormat(
                'Y/m/d h:i:s A',
                $cleaned,
                config('retreat.timezone', 'Africa/Lagos')
            ) ?: null;
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @return array{status: string, notes: ?string}
     */
    private function normalizeTransport(?string $raw): array
    {
        $trimmed = trim((string) $raw);
        $lower = strtolower($trimmed);

        if ($lower === 'yes') {
            return ['status' => 'Yes', 'notes' => null];
        }

        if ($lower === 'no') {
            return ['status' => 'No', 'notes' => null];
        }

        return ['status' => 'Other', 'notes' => $trimmed !== '' ? Str::limit($trimmed, 255, '') : null];
    }

    private function normalizeYesNo(?string $raw): string
    {
        return strtolower(trim((string) $raw)) === 'yes' ? 'Yes' : 'No';
    }
}
