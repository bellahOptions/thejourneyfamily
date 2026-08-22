@extends('layouts.error', [
    'code' => '419',
    'eyebrow' => 'Page expired',
    'heading' => 'That took a little too long.',
    'description' => 'Your session timed out for security. Go back, refresh the page, and give it another try.',
])

@section('actions')
    <a href="javascript:history.back()"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Go back and retry
    </a>
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
        Go to homepage
    </a>
@endsection
