<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordController extends Controller
{
    public function edit(): View
    {
        return view('admin.auth.change-password');
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => $request->validated('password'),
            'must_change_password' => false,
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Your password has been updated.');
    }
}
