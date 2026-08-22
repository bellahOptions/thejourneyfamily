<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Mail\NewQuestionNotification;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class QuestionController extends Controller
{
    public function create(): View
    {
        return view('questions.ask');
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        $question = Question::create([
            'body' => $request->validated('body'),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        // Best-effort — the question is already saved, so a mail failure
        // should never surface to the person submitting it.
        try {
            $organizerEmails = config('retreat.organizer_emails', []);

            if ($organizerEmails !== []) {
                Mail::to($organizerEmails)->send(new NewQuestionNotification($question));
            }
        } catch (Throwable $e) {
            Log::channel('retreat')->error("Question notification mail failure: {$e->getMessage()}", [
                'question_id' => $question->id,
            ]);
        }

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
