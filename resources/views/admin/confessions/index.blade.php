@extends('layouts.admin', ['title' => 'Confessions'])

@section('admin-content')
    <h1 class="font-display text-3xl font-semibold text-gray-950">Confessions</h1>
    <p class="mt-1 text-sm text-[#52625c]">Moderate anonymous confessions shared on the public wall.</p>

    <div class="mt-6 space-y-4">
        @forelse ($confessions as $confession)
            <div class="flex items-start justify-between gap-4 rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm {{ $confession->is_hidden ? 'opacity-50' : '' }}">
                <div>
                    <p class="text-sm leading-6 text-[#23352f]">{{ $confession->body }}</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.16em] text-[#68766f]">
                        {{ $confession->created_at->diffForHumans() }}
                        @if ($confession->is_hidden)
                            · Hidden
                        @endif
                    </p>
                </div>
                <form action="{{ route('admin.confessions.toggle', $confession) }}" method="POST" class="flex-none">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded-lg border border-[#d8cec0] px-4 py-2 text-xs font-semibold text-[#23352f] hover:bg-[#f7f4ee]">
                        {{ $confession->is_hidden ? 'Restore' : 'Hide' }}
                    </button>
                </form>
            </div>
        @empty
            <p class="text-sm text-[#68766f]">No confessions submitted yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $confessions->links() }}
    </div>
@endsection
