<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Answer;
use App\Models\Questionnaire;

beforeEach(function () {
    $this->admin = Admin::first() ?: Admin::factory()->create();
});

test('admin answers can be displayed', function () {
    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->get(route('admin.answers.index'));

    $response->assertOk();
});


test('admin can delete answer', function () {
    $user = User::factory()->create();

    $questionnaire = Questionnaire::factory()->withQuestions()->create();
    $questions = $questionnaire->questions;
    $question_ids = $questions->pluck('id')->all();
    $answers = [];

    foreach ($question_ids as $id) {
        $answers[$id] = rand(0, 2);
    }

    $answer = Answer::factory()->create([
        'questionnaire_id' => $questionnaire->id,
        'user_id' => $user->id,
        'answers' => serialize($answers),
        'questionnaire_data' => serialize($questions),
    ]);

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->delete(route('admin.answers.destroy', $answer));

    $response->assertRedirect(route('admin.answers.index'));

    $this->assertTrue($answer->fresh()->deleted_at !== null);
});
