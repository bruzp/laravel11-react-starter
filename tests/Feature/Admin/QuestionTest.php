<?php

use App\Models\Admin;
use App\Models\Question;
use App\Models\Questionnaire;

beforeEach(function () {
    $this->admin = Admin::first() ?: Admin::factory()->create();
});

test('admin can add question', function () {
    $questionnaire = Questionnaire::factory()->create();

    $choices = [];

    for ($i = 0; $i < rand(3, 5); $i++) {
        $choices[] = fake()->sentence();
    }

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->post(route('admin.questions.store', $questionnaire), [
            'question' => fake()->sentence(),
            'choices' => $choices,
            'answer' => array_rand($choices),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.questionnaires.edit', $questionnaire));
});

test('admin can update question', function () {
    $_question = fake()->sentence();
    $question = Question::factory()->withQuestionnaire()->create();

    $choices = [];

    for ($i = 0; $i < rand(3, 5); $i++) {
        $choices[] = fake()->sentence();
    }

    $answer = array_rand($choices);

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->put(route('admin.questions.update', $question), [
            'question' => $_question,
            'choices' => $choices,
            'answer' => $answer,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.questionnaires.edit', $question->questionnaire));

    $question->refresh();

    $this->assertSame($_question, $question->question);
    $this->assertSame($answer, $question->answer);
    $this->assertSame(serialize($choices), $question->choices);
});

test('admin can delete question', function () {
    $question = Question::factory()->withQuestionnaire()->create();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->delete(route('admin.questions.destroy', $question));

    $response->assertRedirect(route('admin.questionnaires.edit', $question->questionnaire));

    $this->assertTrue($question->fresh()->deleted_at !== null);
});
