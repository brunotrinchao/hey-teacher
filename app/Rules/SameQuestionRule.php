<?php

namespace App\Rules;

use App\Models\Question;
use Illuminate\Contracts\Validation\Rule;

class SameQuestionRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return !Question::whereQuestion($value)->exists();
    }

    public function message(): string
    {
        return 'Essa pergunta já existe.';
    }
}
