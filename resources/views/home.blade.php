@extends('layouts.app', ['title' => config('retreat.name')])

@section('body')
    @include('partials.nav')

    <main class="bg-[#f7f4ee]">
        {{-- Hero --}}
        <section class="relative overflow-hidden bg-gray-950 text-white">
            <img src="{{ asset('host-img.png') }}" alt="The Journey Couples Retreat hosts"
                class="absolute inset-0 h-full w-full object-cover object-center opacity-70">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-gray-950/20"></div>

            <div class="relative mx-auto max-w-6xl px-5 py-20 sm:px-8 sm:py-28 lg:py-36">
                @if ($eventStatus === 'live')
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.32em] text-[#f0b65b]">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#f0b65b] opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-[#f0b65b]"></span>
                        </span>
                        Happening now · Redemption Camp
                    </p>
                @else
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-[#f0b65b]">
                        {{ $eventStartDate->format('F j') }}–{{ $eventEndDate->format('j, Y') }} · Redemption Camp
                    </p>
                @endif

                <h1 class="mt-5 max-w-2xl font-display text-4xl font-semibold leading-tight sm:text-6xl">
                    {{ config('retreat.name') }}
                </h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-white/85 sm:text-lg">
                    A Christian-based retreat for homes, hosted at Redemption Camp with curated accommodation,
                    meals, prayer, and fellowship for couples.
                </p>

                <div class="mt-9 flex flex-wrap gap-4">
                    <a href="{{ route('registrations.create') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-500 px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-600">
                        Register now
                    </a>
                    <a href="#packages"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                        View packages
                    </a>
                </div>

                <div class="mt-12 grid max-w-xl gap-6 text-sm text-white/85 sm:grid-cols-3">
                    <div class="border-l border-[#f0b65b] pl-4">
                        <span class="block text-lg font-semibold text-white">{{ $eventStartDate->format('M j') }}–{{ $eventEndDate->format('j') }}</span>
                        <span>Event dates</span>
                    </div>
                    <div class="border-l border-[#f0b65b] pl-4">
                        <span class="block text-lg font-semibold text-white">2 nights</span>
                        <span>Accommodation</span>
                    </div>
                    <div class="border-l border-[#f0b65b] pl-4">
                        <span class="block text-lg font-semibold text-white">4 meals</span>
                        <span>Per couple</span>
                    </div>
                </div>

                @if ($eventStatus === 'upcoming')
                    <div data-countdown="{{ $eventStartDate->toIso8601String() }}"
                        class="mt-10 grid max-w-md grid-cols-4 gap-3 text-center">
                        @foreach (['days' => 'Days', 'hours' => 'Hrs', 'minutes' => 'Min', 'seconds' => 'Sec'] as $unit => $label)
                            <div class="rounded-xl border border-white/15 bg-white/8 py-3 backdrop-blur">
                                <span data-countdown-unit="{{ $unit }}" class="block font-mono text-2xl font-semibold text-white">00</span>
                                <span class="text-[11px] uppercase tracking-[0.18em] text-white/60">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                @elseif ($eventStatus === 'live')
                    <div class="mt-10 max-w-md rounded-xl border border-[#f0b65b]/40 bg-[#f0b65b]/10 px-5 py-4">
                        <p class="text-sm leading-6 text-white/90">
                            The retreat is live right now at Redemption Camp, running through
                            {{ $eventEndDate->format('g:i A') }} on {{ $eventEndDate->format('l, F j') }}.
                        </p>
                    </div>
                @else
                    <div class="mt-10 max-w-md rounded-xl border border-white/15 bg-white/8 px-5 py-4 backdrop-blur">
                        <p class="text-sm leading-6 text-white/80">
                            This year's retreat has concluded. Thank you to everyone who joined us — see you next
                            time.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- What to expect --}}
        <section class="mx-auto max-w-6xl px-5 py-20 sm:px-8">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">What to expect</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-gray-950 sm:text-4xl">
                    A weekend built for your marriage
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['title' => 'Comfortable accommodation', 'body' => 'Choose from fan, standard AC, or big AC rooms — all built for couples to rest together.'],
                    ['title' => 'Shared meals', 'body' => 'Four meals per couple, served across the retreat so you can fellowship without worry.'],
                    ['title' => 'Prayer & worship', 'body' => 'Guided sessions to help homes reconnect with God and with each other.'],
                    ['title' => 'Practical teaching', 'body' => 'Sessions and counsel drawn from real questions couples bring to the retreat.'],
                ] as $item)
                    <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500/10 text-blue-500">
                            <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                        </div>
                        <h3 class="mt-5 text-base font-semibold text-gray-950">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#52625c]">{{ $item['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Packages preview --}}
        <section id="packages" class="bg-white py-20">
            <div class="mx-auto max-w-6xl px-5 sm:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">Packages</p>
                        <h2 class="mt-3 font-display text-3xl font-semibold text-gray-950 sm:text-4xl">
                            Pick the room that fits your home
                        </h2>
                    </div>
                    <a href="{{ route('registrations.create') }}"
                        class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                        Register for a package →
                    </a>
                </div>

                <div class="mt-10 grid gap-5 lg:grid-cols-3">
                    @foreach ($packages as $package)
                        <div class="rounded-2xl border border-[#d8cec0] bg-[#f7f4ee] p-6 shadow-sm">
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-500">{{ $package['label'] }}</span>
                            <h3 class="mt-3 text-xl font-semibold text-gray-950">{{ $package['room'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-[#52625c]">{{ $package['description'] }}</p>
                            <p class="mt-5 text-2xl font-semibold text-gray-950">NGN {{ number_format($package['price']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Confessions / Q&A teaser --}}
        <section class="mx-auto max-w-6xl px-5 py-20 sm:px-8">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">Share anonymously</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-gray-950 sm:text-4xl">
                    A safe space to be honest
                </h2>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                <a href="{{ route('confessions.index') }}"
                    class="group rounded-2xl border border-[#d8cec0] bg-gray-950 p-8 text-white shadow-sm transition hover:border-[#f0b65b]">
                    <h3 class="text-xl font-semibold">Anonymous confessions</h3>
                    <p class="mt-3 text-sm leading-6 text-white/75">
                        Write and read anonymous confessions shared by couples at the retreat — no names, no
                        judgment.
                    </p>
                    <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#f0b65b]">
                        Open confessions
                        <span class="transition group-hover:translate-x-1">→</span>
                    </span>
                </a>

                <a href="{{ route('questions.create') }}"
                    class="group rounded-2xl border border-[#d8cec0] bg-white p-8 shadow-sm transition hover:border-blue-500">
                    <h3 class="text-xl font-semibold text-gray-950">Ask a question</h3>
                    <p class="mt-3 text-sm leading-6 text-[#52625c]">
                        Send in a question anonymously during a session — selected questions get shown live on
                        screen.
                    </p>
                    <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-blue-600">
                        Ask now
                        <span class="transition group-hover:translate-x-1">→</span>
                    </span>
                </a>
            </div>
        </section>

        {{-- Book a consultation --}}
        <section class="bg-blue-950">
            <div class="mx-auto grid max-w-6xl gap-8 px-5 py-16 sm:px-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#f0b65b]">One-on-one support</p>
                    <h2 class="mt-3 font-display text-3xl font-semibold text-white sm:text-4xl">
                        Book a consultation with a counselor
                    </h2>
                    <p class="mt-4 max-w-lg text-sm leading-6 text-white/75">
                        Some things are easier to talk through privately. Book a one-on-one session with a
                        counselor — before, during, or after the retreat — and we'll reach out on WhatsApp to
                        schedule a time that works for you both.
                    </p>
                </div>
                <a href="{{ route('consultations.create') }}"
                    class="inline-flex w-fit items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942] lg:justify-self-end">
                    Book a consultation
                </a>
            </div>
        </section>

        @include('partials.footer')
    </main>
@endsection
