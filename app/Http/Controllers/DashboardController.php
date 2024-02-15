<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'questions' => Question::query()
                ->withSum('votes', 'like')
                ->withSum('votes', 'unlike')
                ->paginate(5),
        ]);
    }
}
