<?php

use App\Models\{Question, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get, withoutExceptionHandling};

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

test('List link and unlike order', function () {
    // Arrange : Preparar
    $user       = User::factory()->create();
    $secundUser = User::factory()->create();
    Question::factory()->count(5)->create();
    $mostLikeQuestion   = Question::find(3);
    $mostUnlikeQuestion = Question::find(1);
    $user->like($mostLikeQuestion);
    $secundUser->unlike($mostUnlikeQuestion);
    actingAs($user);

    withoutExceptionHandling();

    // Act : Agir
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) use ($mostLikeQuestion, $mostUnlikeQuestion) {
            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });

    // Assent : Verificar
});
