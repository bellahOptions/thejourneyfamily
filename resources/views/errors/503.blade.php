@extends('layouts.error', [
    'code' => '503',
    'eyebrow' => 'Be right back',
    'heading' => "We're doing some quick upkeep.",
    'description' => "The site is briefly offline for maintenance. We'll be back shortly — thanks for your patience.",
])

@section('actions')
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Try again
    </a>
@endsection
