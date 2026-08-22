@extends('layouts.app', ['title' => 'Confessions — '.config('retreat.name')])

@section('body')
    @include('partials.nav')

    <main class="bg-gray-950 text-white">
        <section class="mx-auto max-w-3xl px-5 py-16 sm:px-8" x-data="{ loading: false }">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#f0b65b]">Anonymous confessions</p>
            <h1 class="mt-3 font-display text-4xl font-semibold">A safe space to be honest</h1>
            <p class="mt-4 max-w-xl text-sm leading-6 text-white/70">
                Share what's on your heart — no names, no judgment. Everything here is posted anonymously and read
                by fellow couples at the retreat.
            </p>

            @if (session('status'))
                <div class="mt-8 rounded-lg border border-[#f0b65b]/30 bg-[#f0b65b]/10 p-4 text-sm text-[#f0b65b]" role="status">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mt-8 rounded-lg border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200" role="alert">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('confessions.store') }}" method="POST" class="mt-8" x-on:submit="loading = true">
                @csrf
                <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off"
                    class="absolute left-[-10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">

                <textarea name="body" rows="4" maxlength="1500" required placeholder="Write your confession…"
                    class="w-full rounded-xl border border-white/15 bg-white/5 px-5 py-4 text-white placeholder-white/40 shadow-sm outline-none transition focus:border-[#f0b65b] focus:ring-4 focus:ring-[#f0b65b]/15">{{ old('body') }}</textarea>

                <div class="mt-4 flex items-center justify-between">
                    <p class="text-xs text-white/40">Posted anonymously. Be kind.</p>
                    <button type="submit" x-bind:disabled="loading"
                        class="inline-flex items-center gap-2 rounded-full bg-[#f0b65b] px-6 py-3 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942] disabled:cursor-not-allowed disabled:opacity-70">
                        <span x-text="loading ? 'Sharing…' : 'Share anonymously'"></span>
                    </button>
                </div>
            </form>

            <div class="mt-16 space-y-4">
                @forelse ($confessions as $confession)
                    <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <p class="text-base leading-7 text-white/90">{{ $confession->body }}</p>
                        <p class="mt-4 text-xs uppercase tracking-[0.18em] text-white/35">
                            {{ $confession->created_at->diffForHumans() }}
                        </p>
                    </article>
                @empty
                    <p class="text-sm text-white/50">No confessions shared yet — be the first.</p>
                @endforelse
            </div>

            @if ($confessions->hasPages())
                <div class="mt-10">
                    {{ $confessions->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection
