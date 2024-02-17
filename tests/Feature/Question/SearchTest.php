<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('Pesquisa pergunta', function () {
    $user = User::factory()->create();
    Question::factory()->create(['question' => 'Something else?']);
    Question::factory()->create(['question' => 'My question is?']);

    actingAs($user);

    $response = get(route('dashboard', ['search' => 'question']))->assertSuccessful();

    $response->assertDontSee('Something else?');
    $response->assertSee('My question is?');
});
