@extends('layouts.app', ['title' => 'Book a consultation — '.config('retreat.name')])

@section('body')
    @include('partials.nav')

    <main class="bg-[#f7f4ee]">
        <section class="mx-auto max-w-2xl px-5 py-16 sm:px-8" x-data="{ loading: false }">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">Book a consultation</p>
            <h1 class="mt-3 font-display text-4xl font-semibold text-gray-950">Talk to a counselor</h1>
            <p class="mt-4 max-w-xl text-sm leading-6 text-[#52625c]">
                If you and your spouse would like some one-on-one time with a counselor — before, during, or after
                the retreat — leave your details here and we'll reach out on WhatsApp to schedule a time.
            </p>

            @if (session('status'))
                <div class="mt-8 rounded-lg border border-green-500/25 bg-green-50 p-4 text-sm text-green-800" role="status">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mt-8 rounded-lg border border-red-500/25 bg-[#fff6f7] p-4 text-sm text-[#7c2036]" role="alert">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultations.store') }}" method="POST" class="mt-8 space-y-5"
                x-on:submit="loading = true">
                @csrf
                <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off"
                    class="absolute left-[-10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">

                <label class="block">
                    <span class="text-sm font-semibold text-[#23352f]">Name</span>
                    <input name="couple_name" value="{{ old('couple_name') }}" required maxlength="120"
                        autocomplete="name"
                        class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                    @error('couple_name') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-[#23352f]">WhatsApp number</span>
                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required maxlength="30"
                        inputmode="tel" autocomplete="tel"
                        class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                    @error('whatsapp') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-[#23352f]">Email (optional)</span>
                    <input type="email" name="email" value="{{ old('email') }}" maxlength="160" autocomplete="email"
                        class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
                    @error('email') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-[#23352f]">What would you like to talk about? (optional)</span>
                    <textarea name="notes" rows="4" maxlength="1000"
                        class="mt-2 w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('notes') }}</textarea>
                    @error('notes') <span class="mt-1 block text-sm text-[#a33852]">{{ $message }}</span> @enderror
                </label>

                <button type="submit" x-bind:disabled="loading"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-500 px-6 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-500/25 disabled:cursor-not-allowed disabled:opacity-70">
                    <span x-text="loading ? 'Sending…' : 'Request a consultation'"></span>
                </button>
            </form>
        </section>
    </main>
@endsection
