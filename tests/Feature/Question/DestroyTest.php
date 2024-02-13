<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete, put};

test('Test exclusão da pergunta', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    delete(route('question.destroy', $question))
        ->assertRedirect();

    assertDatabaseMissing('questions', ['id', $question->id]);;
});

test('Somente quem criou a pergunta pode excluir', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['draft' => true, 'created_by_id' => $rightUser->id]);

    actingAs($wrongUser);

    delete(route('question.destroy', $question))
        ->assertForbidden();

    actingAs($rightUser);

    delete(route('question.destroy', $question))
        ->assertRedirect();
});
