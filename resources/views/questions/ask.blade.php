@extends('layouts.app', ['title' => 'Ask a question — '.config('retreat.name')])

@section('body')
    @include('partials.nav')

    <main class="bg-[#f7f4ee]">
        <section class="mx-auto max-w-2xl px-5 py-16 sm:px-8" x-data="{ loading: false }">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-500">Ask a question</p>
            <h1 class="mt-3 font-display text-4xl font-semibold text-gray-950">Ask anything, anonymously</h1>
            <p class="mt-4 max-w-xl text-sm leading-6 text-[#52625c]">
                Send a question during a session — no name attached. Selected questions may be shown on the big
                screen and answered live.
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

            <form action="{{ route('questions.store') }}" method="POST" class="mt-8" x-on:submit="loading = true">
                @csrf
                <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off"
                    class="absolute left-[-10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">

                <textarea name="body" rows="4" maxlength="500" required placeholder="Type your question…"
                    class="w-full rounded-xl border border-[#d8cec0] bg-white px-5 py-4 text-gray-950 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">{{ old('body') }}</textarea>

                <div class="mt-4 flex items-center justify-between">
                    <p class="text-xs text-[#68766f]">Posted anonymously. Max 500 characters.</p>
                    <button type="submit" x-bind:disabled="loading"
                        class="inline-flex items-center gap-2 rounded-full bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-600 disabled:cursor-not-allowed disabled:opacity-70">
                        <span x-text="loading ? 'Sending…' : 'Send question'"></span>
                    </button>
                </div>
            </form>

            <a href="{{ route('questions.live') }}"
                class="mt-10 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                View the live question wall →
            </a>
        </section>
    </main>
@endsection
