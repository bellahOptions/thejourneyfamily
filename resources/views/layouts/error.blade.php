@extends('layouts.app', ['title' => ($heading ?? 'Error').' — '.config('retreat.name', 'The Journey')])

@section('body')
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gray-950 px-6 py-16 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 flex items-center justify-center overflow-hidden">
            <span class="select-none font-display text-[46vw] leading-none text-white/[0.04] sm:text-[32vw]">{{ $code }}</span>
        </div>
        <div aria-hidden="true"
            class="pointer-events-none absolute -top-32 left-1/2 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full bg-[#f0b65b]/10 blur-3xl">
        </div>

        <a href="{{ route('landing') }}" class="absolute left-6 top-6 w-24 sm:left-10 sm:top-10 sm:w-28"
            aria-label="{{ config('retreat.name', 'The Journey') }}">
            <img src="{{ asset('logo.png') }}" alt="{{ config('retreat.name', 'The Journey') }}" class="h-auto w-full opacity-90">
        </a>

        <div class="relative mx-auto max-w-xl text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.32em] text-[#f0b65b]">{{ $eyebrow }}</p>
            <h1 class="mt-5 font-display text-4xl font-semibold leading-tight sm:text-5xl">{{ $heading }}</h1>
            <p class="mt-5 text-base leading-7 text-white/70">{{ $description }}</p>

            <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
                @yield('actions')
            </div>
        </div>
    </main>
@endsection
