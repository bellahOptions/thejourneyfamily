<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Confession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConfessionController extends Controller
{
    public function index(): View
    {
        return view('admin.confessions.index', [
            'confessions' => Confession::query()->latest()->paginate(20),
        ]);
    }

    public function toggleHidden(Confession $confession): RedirectResponse
    {
        $confession->update(['is_hidden' => ! $confession->is_hidden]);

        return back()->with('status', $confession->is_hidden ? 'Confession hidden.' : 'Confession restored.');
    }
}
