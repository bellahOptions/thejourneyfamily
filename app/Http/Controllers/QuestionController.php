<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function create(): View
    {
        return view('questions.ask');
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        Question::create([
            'body' => $request->validated('body'),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        return redirect()
            ->route('questions.create')
            ->with('status', 'Your question was sent anonymously. It may be shown on screen during the session.');
    }

    public function live(): View
    {
        return view('questions.live');
    }

    public function liveData(): JsonResponse
    {
        $questions = Question::query()
            ->visible()
            ->featured()
            ->latest()
            ->limit(20)
            ->get(['id', 'body', 'created_at']);

        if ($questions->isEmpty()) {
            $questions = Question::query()
                ->visible()
                ->where('status', Question::STATUS_PENDING)
                ->latest()
                ->limit(20)
                ->get(['id', 'body', 'created_at']);
        }

        return response()->json([
            'questions' => $questions,
        ]);
    }
}
