@extends('layouts.admin', ['title' => 'Import registrations'])

@section('admin-content')
    <a href="{{ route('admin.registrations.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
        ← All registrations
    </a>

    <h1 class="mt-4 font-display text-3xl font-semibold text-gray-950">Import registrations</h1>
    <p class="mt-1 max-w-2xl text-sm leading-6 text-[#52625c]">
        Upload the original Google Form CSV export (Timestamp, Name, Wedding Anniversary, WhatsApp numbers,
        transport, children, expectations, prayer request, feedback, payment, and questions columns, in that
        order). That export has no email or package column, so imported registrations are saved without them —
        you can fill those in later from each registration's detail page. Rows that match an existing
        registration by name and WhatsApp number are skipped as duplicates.
    </p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-500/25 bg-[#fff6f7] p-4 text-sm text-[#7c2036]" role="alert">
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($summary = session('importSummary'))
        <div class="mt-6 rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-950">Import summary</h2>
            <div class="mt-4 flex flex-wrap gap-6 text-sm">
                <div>
                    <span class="block text-2xl font-semibold text-green-700">{{ $summary['imported'] }}</span>
                    <span class="text-[#68766f]">Imported</span>
                </div>
                <div>
                    <span class="block text-2xl font-semibold text-blue-600">{{ $summary['duplicates'] }}</span>
                    <span class="text-[#68766f]">Duplicates skipped</span>
                </div>
                <div>
                    <span class="block text-2xl font-semibold text-[#a33852]">{{ count($summary['skipped']) }}</span>
                    <span class="text-[#68766f]">Rows skipped</span>
                </div>
            </div>

            @if (! empty($summary['skipped']))
                <ul class="mt-5 space-y-1 border-t border-[#eee7da] pt-4 text-sm text-[#52625c]">
                    @foreach ($summary['skipped'] as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <form action="{{ route('admin.registrations.import.store') }}" method="POST" enctype="multipart/form-data"
        class="mt-8 max-w-lg rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm">
        @csrf

        <label class="block">
            <span class="text-sm font-semibold text-[#23352f]">CSV file</span>
            <input type="file" name="file" accept=".csv,text/csv" required
                class="mt-2 block w-full rounded-lg border border-[#d8cec0] bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none file:mr-4 file:rounded-md file:border-0 file:bg-blue-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        </label>

        <button type="submit"
            class="mt-6 w-full rounded-lg bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-600">
            Upload and import
        </button>
    </form>
@endsection
