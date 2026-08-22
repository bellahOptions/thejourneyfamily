@extends('layouts.error', [
    'code' => '403',
    'eyebrow' => 'Access denied',
    'heading' => "You don't have access to that.",
    'description' => "This page is restricted. If you think that's a mistake, sign in with the right account or head back home.",
])

@section('actions')
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Go to homepage
    </a>
    <a href="{{ route('admin.login') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
        Admin sign in
    </a>
@endsection
