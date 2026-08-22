@php
    $navLinks = [
        ['route' => 'landing', 'label' => 'Home'],
        ['route' => 'registrations.create', 'label' => 'Register'],
        ['route' => 'confessions.index', 'label' => 'Confessions'],
        ['route' => 'questions.create', 'label' => 'Ask a Question'],
    ];
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-[#d8cec0]/70 bg-[#f7f4ee]/90 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-3 sm:px-8">
        <a href="{{ route('landing') }}" class="w-32 shrink-0 sm:w-36" aria-label="The Journey Couples Retreat">
            <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-full">
        </a>

        <nav class="hidden items-center gap-8 text-sm font-semibold text-[#23352f] md:flex">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                    class="transition hover:text-blue-600 {{ request()->routeIs($link['route']) ? 'text-blue-600' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('registrations.create') }}"
                class="rounded-full bg-blue-500 px-5 py-2.5 text-white shadow-sm transition hover:bg-blue-600">
                Register now
            </a>
        </nav>

        <button type="button" x-on:click="open = ! open" aria-label="Toggle menu"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#d8cec0] text-[#23352f] md:hidden">
            <svg x-show="! open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
            <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav x-show="open" x-cloak x-transition class="border-t border-[#d8cec0]/70 bg-[#f7f4ee] px-5 py-4 md:hidden">
        <div class="flex flex-col gap-4 text-base font-semibold text-[#23352f]">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" x-on:click="open = false">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('registrations.create') }}" x-on:click="open = false"
                class="rounded-full bg-blue-500 px-5 py-3 text-center text-white shadow-sm">
                Register now
            </a>
        </div>
    </nav>
</header>
