<?php

use App\Models\Question;

use function Pest\Laravel\{artisan, assertDatabaseMissing, assertSoftDeleted};

test('Deletando arquivos antigos com mais de 1 mês', function () {
    $question = Question::factory()
        ->create(['deleted_at' => now()->subMonths(2)]);

    assertSoftDeleted('questions', ['id' => $question->id]);

    artisan('model:prune');

    assertDatabaseMissing('questions', ['id' => $question->id]);
});
