<?php

use App\Models\User;

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
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('Testa se a pergunta termina com ?', function () {
});

it('Testa se a pergunta tem no mínimo 10 caracteres', function () {
});
