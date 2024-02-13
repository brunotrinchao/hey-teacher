<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
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
            ],
        ]);

        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }
}
