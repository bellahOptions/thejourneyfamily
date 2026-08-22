<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationBookingRequest;
use App\Mail\NewConsultationBookingNotification;
use App\Models\ConsultationBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ConsultationBookingController extends Controller
{
    public function create(): View
    {
        return view('consultations.create');
    }

    public function store(StoreConsultationBookingRequest $request): RedirectResponse
    {
        $booking = ConsultationBooking::create([
            ...$request->safe()->only(['couple_name', 'whatsapp', 'email', 'notes']),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        // Best-effort — the booking is already saved, so a mail failure
        // should never surface to the couple submitting it.
        try {
            $organizerEmails = config('retreat.organizer_emails', []);

            if ($organizerEmails !== []) {
                Mail::to($organizerEmails)->send(new NewConsultationBookingNotification($booking));
            }
        } catch (Throwable $e) {
            Log::channel('retreat')->error("Consultation booking notification mail failure: {$e->getMessage()}", [
                'booking_id' => $booking->id,
            ]);
        }

        return redirect()
            ->route('consultations.create')
            ->with('status', "Thank you, {$booking->couple_name}. We've received your request and will reach out on WhatsApp to schedule a time.");
    }
}
