<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfessionRequest;
use App\Mail\NewConfessionNotification;
use App\Models\Confession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ConfessionController extends Controller
{
    public function index(): View
    {
        return view('confessions.index', [
            'confessions' => Confession::query()
                ->visible()
                ->latest()
                ->paginate(12),
        ]);
    }

    public function store(StoreConfessionRequest $request): RedirectResponse
    {
        $confession = Confession::create([
            'body' => $request->validated('body'),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        // Best-effort — the confession is already saved, so a mail failure
        // should never surface to the person submitting it.
        try {
            $organizerEmails = config('retreat.organizer_emails', []);

            if ($organizerEmails !== []) {
                Mail::to($organizerEmails)->send(new NewConfessionNotification($confession));
            }
        } catch (Throwable $e) {
            Log::channel('retreat')->error("Confession notification mail failure: {$e->getMessage()}", [
                'confession_id' => $confession->id,
            ]);
        }

        return redirect()
            ->route('confessions.index')
            ->with('status', 'Your confession has been shared anonymously. Thank you for your honesty.');
    }
}
