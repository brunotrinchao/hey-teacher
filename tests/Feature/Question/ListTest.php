<?php

use App\Models\{Question, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

test('Lista all the Questions', function () {
    // Arrange : Preparar
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(5)->create();

    // Act : Agir
    $response = get(route('dashboard'));

    // Assent : Verificar

    /** @var Question  $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});

test('Paginate result', function () {
    // Arrange : Preparar
    $user = User::factory()->create();
    actingAs($user);
    Question::factory()->count(20)->create();

    // Act : Agir
    get(route('dashboard'))
        ->assertViewHas('questions', function ($value) {
            return $value instanceof LengthAwarePaginator;
        });

    // Assent : Verificar
});
