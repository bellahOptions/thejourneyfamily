<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ConsultationBookingController extends Controller
{
    public function index(): View
    {
        return view('admin.consultations.index', [
            'bookings' => ConsultationBooking::query()->latest()->paginate(20),
        ]);
    }

    public function updateStatus(Request $request, ConsultationBooking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                ConsultationBooking::STATUS_PENDING,
                ConsultationBooking::STATUS_SCHEDULED,
                ConsultationBooking::STATUS_COMPLETED,
                ConsultationBooking::STATUS_CANCELLED,
            ])],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('status', "Booking marked as {$validated['status']}.");
    }
}
