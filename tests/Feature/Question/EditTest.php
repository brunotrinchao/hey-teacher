<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('Abrir pergunta para editar', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))->assertSuccessful();
});

test('Retornando view certa', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))->assertViewIs('question.edit');
});
