@extends('layouts.admin', ['title' => 'Dashboard'])

@section('admin-content')
    <h1 class="font-display text-3xl font-semibold text-gray-950">Dashboard</h1>
    <p class="mt-1 text-sm text-[#52625c]">An overview of retreat registrations and activity.</p>

    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#68766f]">Total registrations</p>
            <p class="mt-3 text-3xl font-semibold text-gray-950">{{ $totalRegistrations }}</p>
        </div>
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#68766f]">Payment made</p>
            <p class="mt-3 text-3xl font-semibold text-green-700">{{ $paidRegistrations }}</p>
        </div>
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#68766f]">Payment pending</p>
            <p class="mt-3 text-3xl font-semibold text-[#a33852]">{{ $unpaidRegistrations }}</p>
        </div>
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#68766f]">Pending questions</p>
            <p class="mt-3 text-3xl font-semibold text-blue-600">{{ $pendingQuestions }}</p>
        </div>
    </div>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">By package</h2>
            <div class="mt-4 space-y-3">
                @forelse ($packageCounts as $row)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[#52625c]">{{ $row->package_label }}</span>
                        <span class="font-semibold text-gray-950">{{ $row->total }}</span>
                    </div>
                @empty
                    <p class="text-sm text-[#68766f]">No registrations yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Recent registrations</h2>
            <div class="mt-4 space-y-3">
                @forelse ($recentRegistrations as $registration)
                    <a href="{{ route('admin.registrations.show', $registration) }}"
                        class="flex items-center justify-between rounded-lg px-2 py-2 text-sm transition hover:bg-[#f7f4ee]">
                        <span class="font-medium text-gray-950">{{ $registration->couple_name }}</span>
                        <span class="text-[#68766f]">{{ $registration->created_at->diffForHumans() }}</span>
                    </a>
                @empty
                    <p class="text-sm text-[#68766f]">No registrations yet.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.registrations.index') }}" class="mt-4 inline-block text-sm font-semibold text-blue-600 hover:text-blue-700">
                View all registrations →
            </a>
        </div>
    </div>
@endsection
