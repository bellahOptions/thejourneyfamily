<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRetreatRegistrationRequest;
use App\Mail\OrganizerRegistrationNotification;
use App\Mail\ParticipantRegistrationConfirmation;
use App\Models\RetreatRegistration;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RetreatRegistrationController extends Controller
{
    public function index(): View
    {
        return view('welcome', [
            'eventDate' => $this->eventDate(),
            'packages' => config('retreat.packages'),
            'payment' => config('retreat.payment'),
        ]);
    }

    public function store(StoreRetreatRegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $package = config("retreat.packages.{$validated['package_key']}");

        $registration = RetreatRegistration::create([
            ...collect($validated)->except(['consent', 'website', 'package_key'])->all(),
            'confirmation_token' => (string) Str::uuid(),
            'package_key' => $validated['package_key'],
            'package_label' => $package['label'].' - '.$package['room'],
            'package_price' => $package['price'],
            'consent_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        Mail::to($registration->email)->send(new ParticipantRegistrationConfirmation($registration));

        $organizerEmails = config('retreat.organizer_emails', []);

        if ($organizerEmails !== []) {
            Mail::to($organizerEmails)->send(new OrganizerRegistrationNotification($registration));
        }

        return redirect()->route('registrations.confirmation', $registration);
    }

    public function show(RetreatRegistration $registration): View
    {
        return view('registrations.confirmation', [
            'eventDate' => $this->eventDate(),
            'payment' => config('retreat.payment'),
            'registration' => $registration,
        ]);
    }

    private function eventDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            config('retreat.event_date'),
            config('retreat.timezone', config('app.timezone'))
        );
    }
}
