@extends('layouts.app', ['title' => 'Admin login'])

@section('body')
    <main class="flex min-h-screen items-center justify-center bg-gray-950 px-5 py-12 text-white">
        <div class="w-full max-w-sm">
            <a href="{{ route('landing') }}" class="mx-auto block w-28" aria-label="The Journey Couples Retreat">
                <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-full">
            </a>

            <h1 class="mt-8 text-center font-display text-2xl font-semibold">Admin sign in</h1>
            <p class="mt-2 text-center text-sm text-white/60">Manage registrations, confessions, and questions.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200" role="alert">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.attempt') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <label class="block">
                    <span class="text-sm font-semibold text-white/80">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                        class="mt-2 w-full rounded-lg border border-white/15 bg-white/5 px-4 py-3 text-white shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-white/80">Password</span>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="mt-2 w-full rounded-lg border border-white/15 bg-white/5 px-4 py-3 text-white shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">
                </label>

                <button type="submit"
                    class="w-full rounded-lg bg-[#f0b65b] px-6 py-3 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
                    Sign in
                </button>
            </form>
        </div>
    </main>
@endsection
