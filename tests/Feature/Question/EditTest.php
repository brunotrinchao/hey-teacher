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

test('Somente pergunta rascunho podera ser editada', function () {
    $user = User::factory()->create();
    actingAs($user);

    $questionNotDraft = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => false]);
    $questionDraft = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    get(route('question.edit', $questionNotDraft))->assertForbidden();
    get(route('question.edit', $questionDraft))->assertSuccessful();
//        ->assertRedirect()
//        ->assertSessionHas();
});
