<?php

namespace App\Http\Controllers\Question;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class PublishController
{
    public function __invoke(Question $question): RedirectResponse
    {
//        $this->authorize('publish', $question);

        $question->update(['draft' => false]);

        return back();
    }
}
