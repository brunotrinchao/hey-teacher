<?php

namespace App\Policies;

use App\Models\{Question, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function publish(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    public function destroy(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }
}
