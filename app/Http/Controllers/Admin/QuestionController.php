<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.questions.index', [
            'questions' => Question::query()->latest()->paginate(20),
        ]);
    }

    public function updateStatus(Request $request, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                Question::STATUS_PENDING,
                Question::STATUS_FEATURED,
                Question::STATUS_ANSWERED,
            ])],
        ]);

        $question->update(['status' => $validated['status']]);

        return back()->with('status', "Question marked as {$validated['status']}.");
    }

    public function toggleHidden(Question $question): RedirectResponse
    {
        $question->update(['is_hidden' => ! $question->is_hidden]);

        return back()->with('status', $question->is_hidden ? 'Question hidden.' : 'Question restored.');
    }
}
