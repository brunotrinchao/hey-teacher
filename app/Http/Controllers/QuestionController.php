<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\SameQuestionRule;
use Closure;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions'         => user()->questions,
            'archivedQuestions' => user()->questions()->onlyTrashed()->get(),
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] != '?') {
                        $fail("The {$attribute} is invalid.");
                    }
                },
                new SameQuestionRule(),
            ],
        ]);

        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('archive', $question);

        $question->delete();

        return back();
    }
    public function restore(int $id): RedirectResponse
    {
        $question = Question::withTrashed()->find($id);
        $this->authorize('archive', $question);

        $question->restore();

        return back();
    }
    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }
}
