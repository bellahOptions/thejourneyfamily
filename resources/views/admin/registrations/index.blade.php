@extends('layouts.admin', ['title' => 'Registrations'])

@section('admin-content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-gray-950">Registrations</h1>
            <p class="mt-1 text-sm text-[#52625c]">{{ $registrations->total() }} total.</p>
        </div>
        <a href="{{ route('admin.registrations.import') }}"
            class="inline-flex w-fit items-center gap-2 rounded-full border border-[#d8cec0] bg-white px-5 py-2.5 text-sm font-semibold text-[#23352f] shadow-sm hover:bg-[#f7f4ee]">
            Import CSV
        </a>
    </div>

    <form method="GET" class="mt-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search name, email, WhatsApp…"
            class="w-full max-w-xs rounded-lg border border-[#d8cec0] bg-white px-4 py-2.5 text-sm text-gray-950 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">

        <select name="package" class="rounded-lg border border-[#d8cec0] bg-white px-4 py-2.5 text-sm text-gray-950 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
            <option value="">All packages</option>
            @foreach ($packages as $key => $package)
                <option value="{{ $key }}" @selected(($filters['package'] ?? '') === $key)>{{ $package['label'] }}</option>
            @endforeach
        </select>

        <select name="payment" class="rounded-lg border border-[#d8cec0] bg-white px-4 py-2.5 text-sm text-gray-950 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15">
            <option value="">Any payment status</option>
            <option value="Yes" @selected(($filters['payment'] ?? '') === 'Yes')>Paid</option>
            <option value="No" @selected(($filters['payment'] ?? '') === 'No')>Unpaid</option>
        </select>

        <button type="submit" class="rounded-lg bg-blue-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-600">
            Filter
        </button>
        @if (($filters['q'] ?? '') || ($filters['package'] ?? '') || ($filters['payment'] ?? ''))
            <a href="{{ route('admin.registrations.index') }}" class="rounded-lg px-5 py-2.5 text-sm font-semibold text-[#68766f] hover:text-gray-950">
                Clear
            </a>
        @endif
    </form>

    <div class="mt-6 overflow-x-auto rounded-2xl border border-[#d8cec0] bg-white shadow-sm">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-[#d8cec0] text-xs font-semibold uppercase tracking-[0.14em] text-[#68766f]">
                <tr>
                    <th class="px-5 py-3">Couple</th>
                    <th class="px-5 py-3">Package</th>
                    <th class="px-5 py-3">Payment</th>
                    <th class="px-5 py-3">Registered</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#eee7da]">
                @forelse ($registrations as $registration)
                    <tr class="cursor-pointer transition hover:bg-[#f7f4ee]" onclick="window.location='{{ route('admin.registrations.show', $registration) }}'">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-gray-950">{{ $registration->couple_name }}</p>
                            <p class="text-xs text-[#68766f]">
                                @if ($registration->needsEmail())
                                    <span class="font-semibold text-[#a33852]">No email</span>
                                @else
                                    {{ $registration->email }}
                                @endif
                            </p>
                        </td>
                        <td class="px-5 py-4 text-[#23352f]">
                            @if ($registration->needsPackage())
                                <span class="rounded-full bg-[#fff6f7] px-3 py-1 text-xs font-semibold text-[#a33852]">Needs package</span>
                            @else
                                {{ $registration->package_label }}
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $registration->payment_made === 'Yes' ? 'bg-green-100 text-green-800' : 'bg-[#fff6f7] text-[#a33852]' }}">
                                {{ $registration->payment_made === 'Yes' ? 'Paid' : 'Unpaid' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-[#68766f]">{{ $registration->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-[#68766f]">No registrations match your filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
@endsection
