<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

test('Like a question', function () {
    // Arrange : Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    post(route('question.like', $question))->assertRedirect();

    // Assent : Verificar
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});
