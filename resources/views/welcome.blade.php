@extends('layouts.app', ['title' => config('retreat.name')])

@section('body')
    <main class="min-h-screen bg-[#f7f4ee]">
        <section class="grid min-h-screen grid-cols-1 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="relative min-h-[520px] overflow-hidden bg-[#12211d] text-white lg:min-h-screen">
                <img
                    src="{{ asset('host-img.png') }}"
                    alt="The Journey Couples Retreat hosts"
                    class="absolute inset-0 h-full w-full object-cover object-center opacity-80"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#12211d] via-[#12211d]/35 to-transparent"></div>

                <div class="relative flex min-h-[520px] flex-col justify-between p-6 sm:p-10 lg:min-h-screen lg:p-12">
                    <a href="{{ route('landing') }}" class="w-36 sm:w-44" aria-label="The Journey Couples Retreat">
                        <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-full">
                    </a>

                    <div class="max-w-xl pb-4">
                        <p class="mb-4 inline-flex rounded-full bg-white/14 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#f0d39d] ring-1 ring-white/20">
                            Season 6 registration
                        </p>
                        <h1 class="text-4xl font-semibold leading-tight sm:text-5xl lg:text-6xl">
                            The Journey Couples Retreat S6
                        </h1>
                        <p class="mt-5 max-w-lg text-base leading-7 text-white/86 sm:text-lg">
                            A Christian-based retreat for homes, hosted at Redemption Camp with curated accommodation, meals, prayer, and fellowship for couples.
                        </p>
                        <div class="mt-8 grid gap-3 text-sm text-white/88 sm:grid-cols-3">
                            <div class="border-l border-[#f0b65b] pl-4">
                                <span class="block text-lg font-semibold text-white">August 2026</span>
                                <span>Event month</span>
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
                    </div>
                </div>
            </div>

            <div id="registration" class="bg-[#f7f4ee] px-5 py-8 sm:px-8 lg:max-h-screen lg:overflow-y-auto lg:px-12 lg:py-10">
                <div class="mx-auto max-w-3xl">
                    <div class="mb-8 flex flex-col gap-4 border-b border-[#d8cec0] pb-6 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[#a33852]">Registration form</p>
                            <h2 class="mt-2 text-3xl font-semibold text-[#12211d]">Reserve your place</h2>
                        </div>
                        <p class="max-w-sm text-sm leading-6 text-[#52625c]">
                            Countdown is configured for {{ $eventDate->timezone(config('retreat.timezone'))->format('F j, Y g:i A') }} WAT.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-[#a33852]/25 bg-[#fff6f7] p-4 text-sm text-[#7c2036]" role="alert">
                            <p class="font-semibold">Please review the highlighted fields.</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('registrations.store') }}" method="POST" class="space-y-8" novalidate>
                        @csrf
                        <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="absolute left-[-10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">

                        <section class="space-y-5">
                            <div>
                                <h3 class="text-lg font-semibold text-[#12211d]">Couple details</h3>
                                <p class="mt-1 text-sm text-[#68766f]">Your honest responses help the organizers prepare well for you.</p>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm font-semibold text-[#23352f]">Name</span>
                                    <input name="couple_name" value="{{ old('couple_name') }}" required maxlength="120" autocomplete="name" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                    @error('couple_name') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </label>

                                <label class="block">
                                    <span class="text-sm font-semibold text-[#23352f]">Email</span>
                                    <input type="email" name="email" value="{{ old('email') }}" required maxlength="160" autocomplete="email" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                    @error('email') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </label>

                                <label class="block">
                                    <span class="text-sm font-semibold text-[#23352f]">Wedding anniversary</span>
                                    <input type="date" name="wedding_anniversary" value="{{ old('wedding_anniversary') }}" required class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                    @error('wedding_anniversary') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </label>

                                <label class="block">
                                    <span class="text-sm font-semibold text-[#23352f]">Your WhatsApp enabled number</span>
                                    <input name="participant_whatsapp" value="{{ old('participant_whatsapp') }}" required maxlength="30" inputmode="tel" autocomplete="tel" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                    @error('participant_whatsapp') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </label>

                                <label class="block sm:col-span-2">
                                    <span class="text-sm font-semibold text-[#23352f]">Your spouse's WhatsApp enabled number</span>
                                    <input name="spouse_whatsapp" value="{{ old('spouse_whatsapp') }}" required maxlength="30" inputmode="tel" autocomplete="tel" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                    @error('spouse_whatsapp') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </label>
                            </div>
                        </section>

                        <section class="space-y-5">
                            <div>
                                <h3 class="text-lg font-semibold text-[#12211d]">Logistics</h3>
                                <p class="mt-1 text-sm text-[#68766f]">Kindly note that participants may be added to a WhatsApp group.</p>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <fieldset>
                                    <legend class="text-sm font-semibold text-[#23352f]">Do you have the means to commute to Redemption Camp?</legend>
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        @foreach (['Yes', 'No', 'Other'] as $option)
                                            <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-[#2f6f73] has-[:checked]:bg-[#e7f1ef]">
                                                <input type="radio" name="transport_status" value="{{ $option }}" required @checked(old('transport_status') === $option) class="h-4 w-4 accent-[#2f6f73]">
                                                {{ $option }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('transport_status') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </fieldset>

                                <fieldset>
                                    <legend class="text-sm font-semibold text-[#23352f]">Will you be coming with children?</legend>
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        @foreach (['Yes', 'No', 'Maybe'] as $option)
                                            <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-[#2f6f73] has-[:checked]:bg-[#e7f1ef]">
                                                <input type="radio" name="bringing_children" value="{{ $option }}" required @checked(old('bringing_children') === $option) class="h-4 w-4 accent-[#2f6f73]">
                                                {{ $option }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('bringing_children') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                                </fieldset>
                            </div>

                            <label class="block">
                                <span class="text-sm font-semibold text-[#23352f]">If yes, how old are they?</span>
                                <input name="children_ages" value="{{ old('children_ages') }}" maxlength="120" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">
                                <span class="mt-1 block text-xs leading-5 text-[#68766f]">Only children between 0 and 2 years will be allowed at the program.</span>
                                @error('children_ages') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </label>
                        </section>

                        <section class="space-y-5">
                            <div>
                                <h3 class="text-lg font-semibold text-[#12211d]">Select a package</h3>
                                <p class="mt-1 text-sm text-[#68766f]">Registration fee is required to be part of the retreat.</p>
                            </div>

                            <div class="grid gap-4 lg:grid-cols-3">
                                @foreach ($packages as $key => $package)
                                    <label class="group cursor-pointer rounded-lg border border-[#d8cec0] bg-white p-4 shadow-sm transition hover:border-[#2f6f73] has-[:checked]:border-[#a33852] has-[:checked]:ring-4 has-[:checked]:ring-[#a33852]/12">
                                        <input type="radio" name="package_key" value="{{ $key }}" required @checked(old('package_key') === $key) class="sr-only">
                                        <span class="flex items-center justify-between gap-3">
                                            <span class="text-sm font-semibold uppercase tracking-[0.18em] text-[#a33852]">{{ $package['label'] }}</span>
                                            <span class="h-4 w-4 rounded-full border border-[#b9aca0] transition group-has-[:checked]:border-[5px] group-has-[:checked]:border-[#a33852]"></span>
                                        </span>
                                        <span class="mt-3 block text-xl font-semibold text-[#12211d]">{{ $package['room'] }}</span>
                                        <span class="mt-2 block text-sm leading-6 text-[#52625c]">{{ $package['description'] }}</span>
                                        <span class="mt-4 block text-2xl font-semibold text-[#2f6f73]">NGN {{ number_format($package['price']) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('package_key') <span class="block text-sm text-[#a33852]">{{ $message }}</span> @enderror

                            <div class="rounded-lg border border-[#2f6f73]/20 bg-[#edf5f3] p-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2f6f73]">Payment details</p>
                                <dl class="mt-3 grid gap-3 text-sm text-[#23352f] sm:grid-cols-3">
                                    <div>
                                        <dt class="text-[#68766f]">Bank</dt>
                                        <dd class="font-semibold">{{ $payment['bank_name'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[#68766f]">Account name</dt>
                                        <dd class="font-semibold">{{ $payment['account_name'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[#68766f]">Account number</dt>
                                        <dd class="font-semibold">{{ $payment['account_number'] }}</dd>
                                    </div>
                                </dl>
                                <p class="mt-3 text-sm text-[#52625c]">After payment, send proof on WhatsApp to {{ $payment['proof_whatsapp'] }}.</p>
                            </div>

                            <fieldset>
                                <legend class="text-sm font-semibold text-[#23352f]">I have made payment</legend>
                                <div class="mt-3 flex flex-wrap gap-3">
                                    @foreach (['Yes', 'No'] as $option)
                                        <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-[#2f6f73] has-[:checked]:bg-[#e7f1ef]">
                                            <input type="radio" name="payment_made" value="{{ $option }}" required @checked(old('payment_made') === $option) class="h-4 w-4 accent-[#2f6f73]">
                                            {{ $option }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('payment_made') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </fieldset>
                        </section>

                        <section class="space-y-5">
                            <div>
                                <h3 class="text-lg font-semibold text-[#12211d]">Retreat responses</h3>
                            </div>

                            <label class="block">
                                <span class="text-sm font-semibold text-[#23352f]">What are your expectations for this year's retreat?</span>
                                <textarea name="expectations" rows="4" maxlength="2000" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">{{ old('expectations') }}</textarea>
                                @error('expectations') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </label>

                            <label class="block">
                                <span class="text-sm font-semibold text-[#23352f]">What is your prayer request as a couple?</span>
                                <textarea name="prayer_request" rows="4" maxlength="2000" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">{{ old('prayer_request') }}</textarea>
                                @error('prayer_request') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </label>

                            <label class="block">
                                <span class="text-sm font-semibold text-[#23352f]">Feedback from last year's retreat or previous years</span>
                                <textarea name="previous_feedback" rows="3" maxlength="2000" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">{{ old('previous_feedback') }}</textarea>
                                @error('previous_feedback') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </label>

                            <label class="block">
                                <span class="text-sm font-semibold text-[#23352f]">Any other question(s)?</span>
                                <textarea name="questions" rows="3" maxlength="2000" class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-[#12211d] shadow-sm outline-none transition focus:border-[#2f6f73] focus:ring-4 focus:ring-[#2f6f73]/15">{{ old('questions') }}</textarea>
                                @error('questions') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            </label>
                        </section>

                        <div class="border-t border-[#d8cec0] pt-6">
                            <label class="flex gap-3 text-sm leading-6 text-[#52625c]">
                                <input type="checkbox" name="consent" value="1" required @checked(old('consent')) class="mt-1 h-4 w-4 flex-none rounded border-[#b9aca0] text-[#2f6f73] accent-[#2f6f73]">
                                <span>I confirm these details are accurate and agree that The Journey may contact us about this retreat by email or WhatsApp.</span>
                            </label>
                            @error('consent') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror

                            <button type="submit" class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#a33852] px-6 py-4 text-base font-semibold text-white shadow-lg shadow-[#a33852]/20 transition hover:bg-[#87283f] focus:outline-none focus:ring-4 focus:ring-[#a33852]/25">
                                Submit registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
