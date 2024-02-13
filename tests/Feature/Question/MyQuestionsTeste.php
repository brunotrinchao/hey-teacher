<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('List all of my qiestions', function () {
    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()
            ->for($user, 'createdBy')
            ->count(10)
            ->create();

    // Act : Agir
    $response = get(route('question.index'));

    // Assent : Verificar

    /** @var Question  $q */
    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }

    /** @var Question  $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
