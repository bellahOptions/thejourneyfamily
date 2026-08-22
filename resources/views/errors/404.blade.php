@extends('layouts.error', [
    'code' => '404',
    'eyebrow' => 'Page not found',
    'heading' => 'This page wandered off.',
    'description' => "The link you followed may be broken, or the page may have moved. Let's get you back on track.",
])

@section('actions')
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Go to homepage
    </a>
    <a href="{{ route('questions.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
        Ask a question
    </a>
@endsection
