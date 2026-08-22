<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfessionRequest;
use App\Models\Confession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
        Confession::create([
            'body' => $request->validated('body'),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        return redirect()
            ->route('confessions.index')
            ->with('status', 'Your confession has been shared anonymously. Thank you for your honesty.');
    }
}
