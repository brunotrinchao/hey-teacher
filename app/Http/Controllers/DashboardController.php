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
                ->orderByRaw('CASE WHEN votes_sum_like IS NULL THEN 0 ELSE votes_sum_like END DESC, CASE WHEN votes_sum_unlike IS NULL THEN 0 ELSE votes_sum_unlike END')
                ->paginate(5),
        ]);
    }
}
