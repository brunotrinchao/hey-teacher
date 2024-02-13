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

test('Testa apenas 1 voto like permitido', function () {
    // Arrange : Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));

    // Assent : Verificar
    $vote = $user->votes()->where('question_id', '=', $question->id)->get();
    expect($vote)->toHaveCount(1);
});

test('Unlike a question', function () {
    // Arrange : Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    post(route('question.unlike', $question))->assertRedirect();

    // Assent : Verificar
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,
    ]);
});

test('Testa apenas 1 voto unlike permitido', function () {
    // Arrange : Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    post(route('question.unlike', $question));
    post(route('question.unlike', $question));
    post(route('question.unlike', $question));
    post(route('question.unlike', $question));
    post(route('question.unlike', $question));

    // Assent : Verificar
    $vote = $user->votes()->where('question_id', '=', $question->id)->get();
    expect($vote)->toHaveCount(1);
});
