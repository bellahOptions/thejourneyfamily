@extends('layouts.app', ['title' => 'Change password'])

@section('body')
    <main class="flex min-h-screen items-center justify-center bg-gray-950 px-5 py-12 text-white">
        <div class="w-full max-w-sm">
            <a href="{{ route('landing') }}" class="mx-auto block w-28" aria-label="The Journey Couples Retreat">
                <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-full">
            </a>

            <h1 class="mt-8 text-center font-display text-2xl font-semibold">Change your password</h1>
            @if (auth()->user()?->must_change_password)
                <p class="mt-2 text-center text-sm text-white/60">
                    For security, you need to set a new password before continuing.
                </p>
            @else
                <p class="mt-2 text-center text-sm text-white/60">Update the password on your admin account.</p>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200" role="alert">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.password.update') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @method('PUT')

                <label class="block">
                    <span class="text-sm font-semibold text-white/80">Current password</span>
                    <input type="password" name="current_password" required autocomplete="current-password"
                        class="mt-2 w-full rounded-lg border border-white/15 bg-white/5 px-4 py-3 text-white shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-white/80">New password</span>
                    <input type="password" name="password" required autocomplete="new-password"
                        class="mt-2 w-full rounded-lg border border-white/15 bg-white/5 px-4 py-3 text-white shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">
                    <span class="mt-1 block text-xs leading-5 text-white/40">At least 8 characters, with uppercase, lowercase, and a number.</span>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-white/80">Confirm new password</span>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-2 w-full rounded-lg border border-white/15 bg-white/5 px-4 py-3 text-white shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">
                </label>

                <button type="submit"
                    class="w-full rounded-lg bg-[#f0b65b] px-6 py-3 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
                    Update password
                </button>

                @unless (auth()->user()?->must_change_password)
                    <a href="{{ route('admin.dashboard') }}" class="block text-center text-sm font-medium text-white/60 hover:text-white">
                        Cancel
                    </a>
                @endunless
            </form>
        </div>
    </main>
@endsection
