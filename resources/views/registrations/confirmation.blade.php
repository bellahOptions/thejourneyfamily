@extends('layouts.app', ['title' => 'Registration confirmed'])

@section('body')
    <main class="min-h-screen bg-blue-950 px-5 py-8 text-white sm:px-8 lg:px-12">
        <div class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl flex-col">
            <a href="{{ route('landing') }}" class="w-36 sm:w-44" aria-label="The Journey Couples Retreat">
                <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-full mb-5">
            </a>

            <section class="grid flex-1 items-center gap-10 py-10 lg:grid-cols-[1fr_0.8fr]">
                <div>
                    <h1 class="mt-4 text-4xl font-semibold font-display leading-tighter sm:text-5xl">
                        Thank you, {{ $registration->couple_name }}.
                    </h1>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-white/78">
                        Your registration for {{ config('retreat.name') }} has been submitted. A confirmation email has been sent to {{ $registration->email }}.
                    </p>

                    <div class="mt-8 rounded-lg border border-white/12 bg-white/8 p-5">
                        <div
                            class="mt-4 bg-white grid grid-cols-2 gap-3 sm:grid-cols-4"
                            data-countdown="{{ $eventDate->toIso8601String() }}"
                            aria-live="polite"
                        >
                            @foreach (['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds'] as $unit => $label)
                                <div class="rounded-lg bg-white px-4 py-5 text-center text-[#12211d]">
                                    <span class="block text-3xl font-semibold" data-countdown-unit="{{ $unit }}">00</span>
                                    <span class="mt-1 block text-xs font-semibold uppercase tracking-[0.16em] text-[#52625c]">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-sm text-white/70">
                            Event date: {{ $eventDate->timezone(config('retreat.timezone'))->format('l, F j, Y g:i A') }} WAT.
                        </p>
                    </div>
                </div>

                <aside class="rounded-lg bg-[#f7f4ee] p-6 text-[#12211d] shadow-2xl shadow-black/20">
                    <h2 class="text-2xl font-semibold">Registration summary</h2>
                    <dl class="mt-6 space-y-4 text-sm">
                        <div class="flex items-start justify-between gap-5 border-b border-[#d8cec0] pb-3">
                            <dt class="text-[#68766f]">Package</dt>
                            <dd class="text-right font-semibold">{{ $registration->package_label }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-5 border-b border-[#d8cec0] pb-3">
                            <dt class="text-[#68766f]">Amount</dt>
                            <dd class="text-right font-semibold">{{ $registration->formattedPackagePrice() }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-5 border-b border-[#d8cec0] pb-3">
                            <dt class="text-[#68766f]">Payment made</dt>
                            <dd class="text-right font-semibold">{{ $registration->payment_made }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-5 border-b border-[#d8cec0] pb-3">
                            <dt class="text-[#68766f]">WhatsApp</dt>
                            <dd class="text-right font-semibold">{{ $registration->participant_whatsapp }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-5">
                            <dt class="text-[#68766f]">Confirmation</dt>
                            <dd class="text-right font-mono text-xs font-semibold">{{ $registration->confirmation_token }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 rounded-lg border border-[#2f6f73]/20 bg-[#edf5f3] p-4 text-sm leading-6 text-[#23352f]">
                        <p class="font-semibold">Payment proof</p>
                        <p class="mt-1">Send proof of payment to {{ $payment['proof_whatsapp'] }} on WhatsApp.</p>
                    </div>
                    <a href="{{ route('landing') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-lg border border-[#d8cec0] px-5 py-3 text-sm font-semibold text-[#23352f] transition hover:bg-white">
                        Back to homepage
                    </a>
                </aside>
            </section>
        </div>
    </main>
@endsection
