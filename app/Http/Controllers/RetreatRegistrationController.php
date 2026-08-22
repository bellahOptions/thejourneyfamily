<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRetreatRegistrationRequest;
use App\Mail\OrganizerRegistrationNotification;
use App\Mail\ParticipantRegistrationConfirmation;
use App\Models\RetreatRegistration;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class RetreatRegistrationController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'eventStartDate' => $this->eventStartDate(),
            'eventEndDate' => $this->eventEndDate(),
            'eventStatus' => $this->eventStatus(),
            'packages' => config('retreat.packages'),
            'payment' => config('retreat.payment'),
        ]);
    }

    public function create(): View
    {
        return view('registrations.create', [
            'eventStartDate' => $this->eventStartDate(),
            'eventEndDate' => $this->eventEndDate(),
            'packages' => config('retreat.packages'),
            'payment' => config('retreat.payment'),
        ]);
    }

    public function store(StoreRetreatRegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $package = config("retreat.packages.{$validated['package_key']}");

        // 1) Persist the registration first, and let a DB failure alone
        //    trigger the generic error path — a person's slot should never
        //    be lost because an email server hiccuped.
        try {
            $registration = RetreatRegistration::create([
                ...collect($validated)->except(['consent', 'hp_field', 'package_key'])->all(),
                'confirmation_token' => (string) Str::uuid(),
                'package_key' => $validated['package_key'],
                'package_label' => $package['label'].' - '.$package['room'],
                'package_price' => $package['price'],
                'consent_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            ]);
        } catch (Throwable $e) {
            $this->logFailure('registration_create', $e, $request);

            if (app()->environment('local', 'testing')) {
                throw $e;
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Unable to complete registration. Please try again later or contact support.']);
        }

        // 2) Mail is best-effort. The registration already succeeded, so a
        //    mail failure should never bounce the user back to the form —
        //    that just invites duplicate submissions. Log and move on.
        try {
            Mail::to($registration->email)->send(new ParticipantRegistrationConfirmation($registration));

            $organizerEmails = config('retreat.organizer_emails', []);
            if ($organizerEmails !== []) {
                Mail::to($organizerEmails)->send(new OrganizerRegistrationNotification($registration));
            }
        } catch (Throwable $e) {
            $this->logFailure('registration_mail', $e, $request, ['registration_id' => $registration->id]);
            // Optionally: dispatch a queued retry job here instead of just logging.
        }

        return redirect()
            ->route('registrations.confirmation', $registration)
            ->with('status', 'Registration received! Check your email for confirmation.');
    }

    public function show(RetreatRegistration $registration): View
    {
        return view('registrations.confirmation', [
            'eventStartDate' => $this->eventStartDate(),
            'eventEndDate' => $this->eventEndDate(),
            'eventStatus' => $this->eventStatus(),
            'payment' => config('retreat.payment'),
            'registration' => $registration,
        ]);
    }

    private function eventStartDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            config('retreat.event_start_date'),
            config('retreat.timezone', config('app.timezone'))
        );
    }

    private function eventEndDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            config('retreat.event_end_date'),
            config('retreat.timezone', config('app.timezone'))
        );
    }

    /**
     * @return 'upcoming'|'live'|'ended'
     */
    private function eventStatus(): string
    {
        $now = CarbonImmutable::now(config('retreat.timezone', config('app.timezone')));

        return match (true) {
            $now->lessThan($this->eventStartDate()) => 'upcoming',
            $now->greaterThan($this->eventEndDate()) => 'ended',
            default => 'live',
        };
    }

    /**
     * Structured logging to a dedicated daily channel so registration
     * failures are easy to find and don't get lost in laravel.log noise.
     * Add a "retreat" channel in config/logging.php (see below).
     */
    private function logFailure(string $stage, Throwable $e, $request, array $context = []): void
    {
        Log::channel('retreat')->error("Retreat registration failure [{$stage}]: {$e->getMessage()}", [
            'stage' => $stage,
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'ip' => $request->ip(),
            'trace' => collect(explode("\n", $e->getTraceAsString()))->take(10)->implode("\n"),
            ...$context,
        ]);
    }
}
