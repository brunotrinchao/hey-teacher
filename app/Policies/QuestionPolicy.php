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

    public function archive(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    public function destroy(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    public function update(User $user, Question $question): bool
    {
        $q = $question->toArray();

        return $q['draft'] && $question->createdBy->is($user);
    }
}
