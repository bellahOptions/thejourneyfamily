@extends('layouts.admin', ['title' => 'Questions'])

@section('admin-content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-gray-950">Questions</h1>
            <p class="mt-1 text-sm text-[#52625c]">Feature a question to show it on the live projector wall.</p>
        </div>
        <a href="{{ route('questions.live') }}" target="_blank" rel="noopener"
            class="inline-flex items-center gap-2 rounded-full bg-gray-950 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-900">
            Open projector view →
        </a>
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($questions as $question)
            <div class="flex flex-col gap-4 rounded-2xl border border-[#d8cec0] bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between {{ $question->is_hidden ? 'opacity-50' : '' }}">
                <div>
                    <p class="text-sm leading-6 text-[#23352f]">{{ $question->body }}</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.16em] text-[#68766f]">
                        {{ $question->created_at->diffForHumans() }} ·
                        <span class="font-semibold">{{ ucfirst($question->status) }}</span>
                        @if ($question->is_hidden)
                            · Hidden
                        @endif
                    </p>
                </div>

                <div class="flex flex-none flex-wrap gap-2">
                    <form action="{{ route('admin.questions.status', $question) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="featured">
                        <button type="submit" class="rounded-lg border border-blue-500 px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50">
                            Feature
                        </button>
                    </form>
                    <form action="{{ route('admin.questions.status', $question) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="answered">
                        <button type="submit" class="rounded-lg border border-[#d8cec0] px-3 py-2 text-xs font-semibold text-[#23352f] hover:bg-[#f7f4ee]">
                            Mark answered
                        </button>
                    </form>
                    <form action="{{ route('admin.questions.toggle', $question) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg border border-[#d8cec0] px-3 py-2 text-xs font-semibold text-[#23352f] hover:bg-[#f7f4ee]">
                            {{ $question->is_hidden ? 'Restore' : 'Hide' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-[#68766f]">No questions submitted yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $questions->links() }}
    </div>
@endsection
