<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $query = RetreatRegistration::query()->latest();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($query) use ($search) {
                $query->where('couple_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('participant_whatsapp', 'like', "%{$search}%")
                    ->orWhere('spouse_whatsapp', 'like', "%{$search}%");
            });
        }

        if ($package = $request->query('package')) {
            $query->where('package_key', $package);
        }

        if ($payment = $request->query('payment')) {
            $query->where('payment_made', $payment);
        }

        return view('admin.registrations.index', [
            'registrations' => $query->paginate(20)->withQueryString(),
            'packages' => config('retreat.packages'),
            'filters' => $request->only('q', 'package', 'payment'),
        ]);
    }

    public function show(RetreatRegistration $registration): View
    {
        return view('admin.registrations.show', [
            'registration' => $registration,
        ]);
    }
}
