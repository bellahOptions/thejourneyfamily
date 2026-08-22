@extends('layouts.admin', ['title' => $registration->couple_name])

@section('admin-content')
    <a href="{{ route('admin.registrations.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
        ← All registrations
    </a>

    <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-gray-950">{{ $registration->couple_name }}</h1>
            <p class="mt-1 text-sm text-[#52625c]">Registered {{ $registration->created_at->format('F j, Y g:i A') }}</p>
        </div>
        <div class="flex flex-none flex-wrap gap-2">
            @if ($registration->needsEmail())
                <span class="rounded-full bg-[#fff6f7] px-4 py-1.5 text-sm font-semibold text-[#a33852]">No email</span>
            @endif
            @if ($registration->needsPackage())
                <span class="rounded-full bg-[#fff6f7] px-4 py-1.5 text-sm font-semibold text-[#a33852]">Needs package</span>
            @endif
            <span class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $registration->payment_made === 'Yes' ? 'bg-green-100 text-green-800' : 'bg-[#fff6f7] text-[#a33852]' }}">
                {{ $registration->payment_made === 'Yes' ? 'Payment made' : 'Payment pending' }}
            </span>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Couple details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @foreach ([
                    'Email' => $registration->email ?: '—',
                    'Wedding anniversary' => $registration->anniversaryLabel(),
                    'Your WhatsApp' => $registration->participant_whatsapp,
                    "Spouse's WhatsApp" => $registration->spouse_whatsapp,
                ] as $label => $value)
                    <div class="flex items-start justify-between gap-4 border-b border-[#eee7da] pb-3">
                        <dt class="text-[#68766f]">{{ $label }}</dt>
                        <dd class="text-right font-medium text-gray-950">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Logistics</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @foreach ([
                    'Can commute?' => $registration->transport_status,
                    'Travel notes' => $registration->transport_notes ?: '—',
                    'Coming with children?' => $registration->bringing_children,
                    'Children ages' => $registration->children_ages ?: '—',
                ] as $label => $value)
                    <div class="flex items-start justify-between gap-4 border-b border-[#eee7da] pb-3">
                        <dt class="text-[#68766f]">{{ $label }}</dt>
                        <dd class="text-right font-medium text-gray-950">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Package &amp; payment</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @foreach ([
                    'Package' => $registration->package_label ?: '—',
                    'Amount' => $registration->formattedPackagePrice(),
                    'Payment made' => $registration->payment_made,
                    'Payment proof note' => $registration->payment_proof_note ?: '—',
                ] as $label => $value)
                    <div class="flex items-start justify-between gap-4 border-b border-[#eee7da] pb-3">
                        <dt class="text-[#68766f]">{{ $label }}</dt>
                        <dd class="max-w-xs text-right font-medium text-gray-950">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Questionnaire</h2>
            <div class="mt-4 space-y-4 text-sm">
                @foreach ([
                    'Expectations' => $registration->expectations,
                    'Prayer request' => $registration->prayer_request,
                    'Previous feedback' => $registration->previous_feedback,
                    'Other questions' => $registration->questions,
                ] as $label => $value)
                    <div>
                        <dt class="font-semibold text-[#23352f]">{{ $label }}</dt>
                        <dd class="mt-1 leading-6 text-[#52625c]">{{ $value ?: '—' }}</dd>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
