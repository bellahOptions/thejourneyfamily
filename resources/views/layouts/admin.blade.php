@extends('layouts.app', ['title' => ($title ?? 'Dashboard').' — Admin'])

@section('body')
    @php
        $adminNav = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
            ['route' => 'admin.registrations.index', 'label' => 'Registrations'],
            ['route' => 'admin.confessions.index', 'label' => 'Confessions'],
            ['route' => 'admin.questions.index', 'label' => 'Questions'],
        ];
    @endphp

    <div class="min-h-screen bg-[#f7f4ee] lg:flex">
        <aside class="border-b border-[#d8cec0] bg-gray-950 text-white lg:min-h-screen lg:w-64 lg:flex-none">
            <div class="flex items-center justify-between px-6 py-6 lg:block">
                <a href="{{ route('admin.dashboard') }}" class="block w-28">
                    <img src="{{ asset('logo.png') }}" alt="{{ config('retreat.name') }}" class="h-auto w-full">
                </a>
                <p class="mt-1 hidden text-xs uppercase tracking-[0.22em] text-white/40 lg:block">Admin</p>
            </div>

            <nav class="flex gap-1 overflow-x-auto px-4 pb-4 text-sm font-medium lg:flex-col lg:gap-1 lg:px-4 lg:pb-0">
                @foreach ($adminNav as $item)
                    <a href="{{ route($item['route']) }}"
                        class="whitespace-nowrap rounded-lg px-4 py-2.5 transition {{ request()->routeIs($item['route'].'*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <form action="{{ route('admin.logout') }}" method="POST" class="border-t border-white/10 px-4 py-4">
                @csrf
                <button type="submit" class="text-sm font-medium text-white/60 hover:text-white">
                    Log out
                </button>
            </form>
        </aside>

        <div class="flex-1 px-5 py-10 sm:px-8 lg:px-12">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-green-500/25 bg-green-50 p-4 text-sm text-green-800" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @yield('admin-content')
        </div>
    </div>
@endsection
