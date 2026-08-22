@extends('layouts.admin', ['title' => 'Consultations'])

@section('admin-content')
    <h1 class="font-display text-3xl font-semibold text-gray-950">Consultations</h1>
    <p class="mt-1 text-sm text-[#52625c]">Couples who've asked to speak with a counselor.</p>

    @php
        $statusStyles = [
            'pending' => 'bg-[#fff6f7] text-[#a33852]',
            'scheduled' => 'bg-blue-100 text-blue-700',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-gray-100 text-gray-600',
        ];
    @endphp

    <div class="mt-6 space-y-4">
        @forelse ($bookings as $booking)
            <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="font-semibold text-gray-950">{{ $booking->couple_name }}</p>
                        <p class="mt-1 text-sm text-[#52625c]">{{ $booking->whatsapp }}
                            @if ($booking->email)
                                · {{ $booking->email }}
                            @endif
                        </p>
                        @if ($booking->notes)
                            <p class="mt-3 max-w-xl text-sm leading-6 text-[#23352f]">{{ $booking->notes }}</p>
                        @endif
                        <p class="mt-3 text-xs uppercase tracking-[0.16em] text-[#68766f]">
                            {{ $booking->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="flex flex-none flex-col items-start gap-3 sm:items-end">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($booking->status) }}
                        </span>

                        <form action="{{ route('admin.consultations.status', $booking) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="rounded-lg border border-[#d8cec0] bg-white px-3 py-1.5 text-xs font-semibold text-[#23352f] shadow-sm outline-none focus:border-blue-500">
                                @foreach (['pending', 'scheduled', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($booking->status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-[#68766f]">No consultation requests yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
@endsection
