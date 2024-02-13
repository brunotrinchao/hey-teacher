<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

test('Test publicação da pergunta', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
//        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    put(route('question.publish', $question))
        ->assertRedirect();

    $question = Question::find($question->id);
    $draft    = $question->toArray();

    expect($draft['draft'])->toBeFalse();
});

test('Somente quem criou a pergunta pode publicar', function () {
});
