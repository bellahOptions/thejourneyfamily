<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Confession;
use App\Models\Question;
use App\Models\RetreatRegistration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $registrations = RetreatRegistration::query();

        return view('admin.dashboard', [
            'totalRegistrations' => (clone $registrations)->count(),
            'paidRegistrations' => (clone $registrations)->where('payment_made', 'Yes')->count(),
            'unpaidRegistrations' => (clone $registrations)->where('payment_made', 'No')->count(),
            'packageCounts' => (clone $registrations)
                ->selectRaw('package_key, package_label, count(*) as total')
                ->groupBy('package_key', 'package_label')
                ->get(),
            'recentRegistrations' => (clone $registrations)->latest()->limit(5)->get(),
            'pendingQuestions' => Question::query()->visible()->where('status', Question::STATUS_PENDING)->count(),
            'totalConfessions' => Confession::query()->visible()->count(),
        ]);
    }
}
