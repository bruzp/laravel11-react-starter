<?php

use App\Models\User;
use App\Models\Questionnaire;

test('exam page can be displayed', function () {
    $response = $this->get(route('exams'));

    $response->assertStatus(200);
});

test('take exam page can be accessed', function () {
    $user = User::factory()->create();
    $questionnaire = Questionnaire::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('take-exam', $questionnaire));

    $response->assertOk();
});

test('exam checker is working', function () {
    $user = User::factory()->create();
    $questionnaire = Questionnaire::factory()->withQuestions()->create();
    $questions = $questionnaire->questions;
    $question_ids = $questions->pluck('id')->all();
    $answers = [];

    foreach ($question_ids as $id) {
        $answers[$id] = rand(0, 2);
    }

    $response = $this
        ->actingAs($user)
        ->post(route('check-exam', $questionnaire), ['answers' => $answers]);

    $response->assertRedirect(route('exam-result'));
});

test('exam result page can be rendered', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->withSession(['status' => 'success'])
        ->get(route('exam-result'));

    $response->assertOk();
});
