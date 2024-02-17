<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

test('Nova pergunta com até 255 catacteres', function () {
    // Arrange : Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act : Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assent : Verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

//it('Testa se a pergunta termina com ?', function () {
//    // Arrange : Preparar
//    $user = User::factory()->create();
//    actingAs($user);
//
//    // Act : Agir
//    $request = post(route('question.store'), [
//        'question' => str_repeat('*', 10) . '?',
//    ]);
//
//    // Assent : Verificar
//    $request->assertSessionHasErrors('question');
//    assertDatabaseCount('questions', 0);
//
//});

it('Testa se a pergunta tem no mínimo 10 caracteres', function () {
    // Arrange : Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act : Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assent : Verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('Testa se criou a pergunta como rascunho', function () {
    // Arrange : Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act : Agir
    post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assent : Verificar
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
        'draft'    => true,
    ]);
});

test('Only authentication a new question', function () {
    post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ])->assertRedirect(route('login'));
});

test('Pergunta única', function () {
    $user = User::factory()->create();
    actingAs($user);

    Question::factory()->create(['question' => 'Alguma Pergunta?']);

    post(route('question.store'), [
        'question' => 'Alguma Pergunta?',
    ])->assertSessionHasErrors('question');
});
