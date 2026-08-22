@extends('layouts.app', ['title' => 'Register — '.config('retreat.name')])

@section('body')
    @include('partials.nav')

    <main class="bg-[#f7f4ee]">
        <section class="mx-auto max-w-4xl px-5 py-12 sm:px-8 sm:py-16" x-data="{ loading: false }">
            <div class="mb-8 flex flex-col gap-4 border-b border-[#d8cec0] pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">Registration</p>
                    <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-gray-950">
                        Reserve your place
                    </h1>
                    <p class="mt-2 max-w-lg text-sm leading-6 text-[#52625c]">
                        Your honest responses help the organizers prepare well for you and your spouse.
                    </p>
                </div>
                <p id="live-clock" class="max-w-sm font-mono text-sm leading-6 text-[#52625c] sm:text-right">
                    welcome....
                </p>
            </div>

            @if ($errors->any())
                <div id="form-errors" tabindex="-1"
                    class="mb-6 rounded-lg border border-red-500/25 bg-[#fff6f7] p-4 text-sm text-[#7c2036]" role="alert">
                    <p class="font-semibold">Please review the highlighted fields.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>document.getElementById('form-errors')?.focus();</script>
            @endif
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-green-500/25 bg-green-50 p-4 text-sm text-green-800" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('registrations.store') }}" method="POST" class="space-y-8" novalidate
                x-on:submit="loading = true">
                @csrf
                <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off"
                    class="absolute left-[-10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">

                <section class="space-y-5">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-950">Couple details</h2>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-semibold text-[#23352f]">Name</span>
                            <input name="couple_name" value="{{ old('couple_name') }}" required maxlength="120"
                                autocomplete="name"
                                class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                            @error('couple_name') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-[#23352f]">Email</span>
                            <input type="email" name="email" value="{{ old('email') }}" required maxlength="160"
                                autocomplete="email"
                                class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                            @error('email') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </label>

                        <div class="sm:col-span-2">
                            <span class="text-sm font-semibold text-[#23352f]">Wedding anniversary (day & month)</span>
                            <div class="mt-2 grid grid-cols-2 gap-3">
                                <select name="anniversary_day" required
                                    class="w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                                    <option value="" disabled {{ old('anniversary_day') ? '' : 'selected' }}>Day</option>
                                    @for ($day = 1; $day <= 31; $day++)
                                        <option value="{{ $day }}" @selected((int) old('anniversary_day') === $day)>{{ $day }}</option>
                                    @endfor
                                </select>
                                <select name="anniversary_month" required
                                    class="w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                                    <option value="" disabled {{ old('anniversary_month') ? '' : 'selected' }}>Month</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                        <option value="{{ $index + 1 }}" @selected((int) old('anniversary_month') === $index + 1)>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('anniversary_day') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                            @error('anniversary_month') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block">
                            <span class="text-sm font-semibold text-[#23352f]">Your WhatsApp enabled number</span>
                            <input type="tel" name="participant_whatsapp" value="{{ old('participant_whatsapp') }}"
                                required maxlength="30" inputmode="tel" autocomplete="tel"
                                class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                            @error('participant_whatsapp') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-[#23352f]">Your spouse's WhatsApp enabled number</span>
                            <input type="tel" name="spouse_whatsapp" value="{{ old('spouse_whatsapp') }}" required
                                maxlength="30" inputmode="tel" autocomplete="tel"
                                class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                            @error('spouse_whatsapp') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </label>
                    </div>
                    <p class="text-xs leading-5 text-[#68766f]">Kindly note that participants may be added to a WhatsApp group.</p>
                </section>

                <section class="space-y-5" x-data="{ transport: '{{ old('transport_status') }}' }">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-950">Logistics</h2>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <fieldset>
                            <legend class="text-sm font-semibold text-[#23352f]">Do you have the means to commute to Redemption Camp?</legend>
                            <div class="mt-3 flex flex-wrap gap-3">
                                @foreach (['Yes', 'No', 'Other'] as $option)
                                    <label
                                        class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-500/10">
                                        <input type="radio" name="transport_status" value="{{ $option }}" required
                                            x-model="transport" @checked(old('transport_status') === $option) class="h-4 w-4 accent-blue-500">
                                        {{ $option }}
                                    </label>
                                @endforeach
                            </div>
                            @error('transport_status') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </fieldset>

                        <fieldset>
                            <legend class="text-sm font-semibold text-[#23352f]">Will you be coming with children?</legend>
                            <div class="mt-3 flex flex-wrap gap-3">
                                @foreach (['Yes', 'No'] as $option)
                                    <label
                                        class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-500/10">
                                        <input type="radio" name="bringing_children" value="{{ $option }}" required
                                            @checked(old('bringing_children') === $option) class="h-4 w-4 accent-blue-500">
                                        {{ $option }}
                                    </label>
                                @endforeach
                            </div>
                            @error('bringing_children') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </fieldset>
                    </div>

                    <div x-show="transport === 'Other'" x-cloak x-transition>
                        <label class="block">
                            <span class="text-sm font-semibold text-[#23352f]">Tell us a bit more about your travel plans</span>
                            <input name="transport_notes" value="{{ old('transport_notes') }}" maxlength="255"
                                class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                            @error('transport_notes') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">If yes, how old are they?</span>
                        <input name="children_ages" value="{{ old('children_ages') }}" maxlength="120"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                        <span class="mt-1 block text-xs leading-5 text-gray-500">Only children between 0 and 2 years will be allowed at the program.</span>
                        @error('children_ages') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>
                </section>

                <section class="space-y-5">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-950">Select a package</h2>
                        <p class="mt-1 text-sm text-gray-500">Registration fee is required to be part of the retreat.</p>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-3">
                        @foreach ($packages as $key => $package)
                            <label
                                class="group cursor-pointer rounded-lg border border-[#d8cec0] bg-white p-4 shadow-sm transition hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:ring-4 has-[:checked]:ring-blue-500/12">
                                <input type="radio" name="package_key" value="{{ $key }}" required
                                    @checked(old('package_key') === $key) class="sr-only">
                                <span class="flex items-center justify-between gap-3 bg-blue-500/5 px-4 py-2 text-sm font-medium text-blue-500 transition group-has-[:checked]:bg-blue-500/10">
                                    <span class="text-sm font-semibold uppercase text-blue-500">{{ $package['label'] }}</span>
                                    <span class="h-4 w-4 rounded-full border border-blue-500 transition group-has-[:checked]:border-[5px]"></span>
                                </span>
                                <span class="mt-3 block text-xl font-semibold text-gray-950">{{ $package['room'] }}</span>
                                <span class="mt-2 block text-sm leading-6 text-[#52625c]">{{ $package['description'] }}</span>
                                <span class="mt-4 block text-2xl font-semibold text-blue-500">NGN {{ number_format($package['price']) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('package_key') <span class="block text-sm text-[#a33852]">{{ $message }}</span> @enderror

                    <div class="rounded-lg border border-blue-500/20 bg-blue-100 p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-500">Payment details</p>
                        <dl class="mt-3 grid gap-3 text-sm text-[#23352f] sm:grid-cols-3">
                            <div>
                                <dt class="text-gray-500">Bank</dt>
                                <dd class="font-semibold">{{ $payment['bank_name'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Account name</dt>
                                <dd class="font-semibold">{{ $payment['account_name'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Account number</dt>
                                <dd class="font-semibold">{{ $payment['account_number'] }}</dd>
                            </div>
                        </dl>
                        <p class="mt-3 text-sm text-[#52625c]">After payment, send proof on WhatsApp to {{ $payment['proof_whatsapp'] }}.</p>
                    </div>

                    <fieldset>
                        <legend class="text-sm font-semibold text-[#23352f]">I have made payment</legend>
                        <div class="mt-3 flex flex-wrap gap-3">
                            @foreach (['Yes', 'No'] as $option)
                                <label
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-4 py-2 text-sm font-medium text-[#23352f] transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-100">
                                    <input type="radio" name="payment_made" value="{{ $option }}" required
                                        @checked(old('payment_made') === $option) class="h-4 w-4 accent-blue-500">
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                        @error('payment_made') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </fieldset>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">Already sent proof, or want to tell us when you will?</span>
                        <textarea name="payment_proof_note" rows="2" maxlength="500"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('payment_proof_note') }}</textarea>
                        @error('payment_proof_note') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>
                </section>

                <section class="space-y-5">
                    <div>
                        <h2 class="font-display text-2xl font-semibold text-gray-950">Retreat questionnaire</h2>
                    </div>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">What are your expectations for this year's retreat?</span>
                        <textarea name="expectations" rows="4" maxlength="2000"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('expectations') }}</textarea>
                        @error('expectations') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">What is your prayer request as a couple?</span>
                        <textarea name="prayer_request" rows="4" maxlength="2000"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('prayer_request') }}</textarea>
                        @error('prayer_request') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">Feedback from last year's retreat or previous years</span>
                        <textarea name="previous_feedback" rows="3" maxlength="2000"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('previous_feedback') }}</textarea>
                        @error('previous_feedback') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-[#23352f]">Any other question(s)?</span>
                        <textarea name="questions" rows="3" maxlength="2000"
                            class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('questions') }}</textarea>
                        @error('questions') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                    </label>
                </section>

                <div class="border-t border-[#d8cec0] pt-6">
                    <label class="flex gap-3 text-sm leading-6 text-[#52625c]">
                        <input type="checkbox" name="consent" value="1" required @checked(old('consent'))
                            class="mt-1 h-4 w-4 flex-none rounded border-[#b9aca0] text-blue-500 accent-blue-500">
                        <span>I confirm these details are accurate and agree that The Journey may contact us about this retreat by email or WhatsApp.</span>
                    </label>
                    @error('consent') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror

                    <button type="submit" x-bind:disabled="loading"
                        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-500 px-6 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-500/25 disabled:cursor-not-allowed disabled:opacity-70">
                        <svg x-show="loading" class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? 'Submitting…' : 'Submit registration'"></span>
                    </button>
                </div>
            </form>
        </section>
    </main>
@endsection
