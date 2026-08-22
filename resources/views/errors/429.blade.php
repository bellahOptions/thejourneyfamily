@extends('layouts.error', [
    'code' => '429',
    'eyebrow' => 'Slow down',
    'heading' => "That's a lot of requests.",
    'description' => "You've hit a rate limit — this keeps the site fast and fair for everyone. Wait a minute and try again.",
])

@section('actions')
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Go to homepage
    </a>
@endsection
