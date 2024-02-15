<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, get, put};

test('Atualiza pergunta no banco', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by_id' => $user->id]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect('question.index');

    $question->refresh();

    expect($question)->question->toBe('Updated Question?');
});

test('Abrir pergunta para update', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), ['question' => 'Updated Question?'])->assertRedirect();
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

    put(route('question.update', $questionNotDraft))->assertForbidden();
    put(route('question.update', $questionDraft), ['question' => 'Updated Question?'])->assertRedirect();
//        ->assertRedirect()
//        ->assertSessionHas();
});

test('Somente quem criou a pergunta pode editar', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['draft' => true, 'created_by_id' => $rightUser->id]);

    actingAs($wrongUser);

    put(route('question.update', $question))
        ->assertForbidden();

    actingAs($rightUser);

    put(route('question.update', $question), ['question' => 'Updated Question?'])
        ->assertRedirect();
});

test('Nova pergunta com até 255 catacteres', function () {
    // Arrange : Preparar
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    // Act : Agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assent : Verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

//it('Testa se a pergunta termina com ?', function () {
//    $user     = User::factory()->create();
//    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
//    actingAs($user);
//
//    $request = put(route('question.update', $question), [
//        'question' => str_repeat('*', 10),
//    ]);
//
//    $request->assertSessionHasErrors([
//        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
//    ]);
//
//    assertDatabaseHas('questions', [
//        'question' => $question->question,
//    ]);
//
//});

//it('Testa se a pergunta tem no mínimo 10 caracteres', function () {
//    $user     = User::factory()->create();
//    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
//    actingAs($user);
//
//    $request = put(route('question.update', $question), [
//        'question' => str_repeat('*', 8) . '?',
//    ]);
//
//    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
//    assertDatabaseHas('questions', [
//        'question' => $question->question,
//    ]);
//});
