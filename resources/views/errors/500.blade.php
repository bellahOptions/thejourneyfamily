@extends('layouts.error', [
    'code' => '500',
    'eyebrow' => 'Something went wrong',
    'heading' => 'Our fault, not yours.',
    'description' => "Something broke on our end. We've been notified and we're looking into it — please try again shortly.",
])

@section('actions')
    <a href="{{ route('landing') }}"
        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f0b65b] px-7 py-3.5 text-sm font-semibold text-gray-950 shadow-lg transition hover:bg-[#e6a942]">
        Go to homepage
    </a>
@endsection
