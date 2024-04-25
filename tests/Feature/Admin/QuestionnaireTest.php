<?php

use App\Models\Admin;
use App\Models\Questionnaire;

beforeEach(function () {
    $this->admin = Admin::first() ?: Admin::factory()->create();
});

test('admin questionnaires can be displayed', function () {
    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->get(route('admin.questionnaires.index'));

    $response->assertOk();
});

test('admin questionnaire registration screen can be rendered', function () {
    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->get(route('admin.questionnaires.create'));

    $response->assertOk();
});

test('admin can add questionnaire', function () {
    $title = fake()->sentence();
    $description = fake()->paragraph();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->post(route('admin.questionnaires.store'), [
            'title' => $title,
            'description' => $description,
        ]);

    $questionnaire = Questionnaire::query()
        ->where('title', $title)
        ->where('description', $description)
        ->first();

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.questionnaires.edit', $questionnaire));
});

test('admin questionnaire edit screen can be rendered', function () {
    $questionnaire = Questionnaire::factory()->create();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->get(route('admin.questionnaires.edit', $questionnaire));

    $response->assertOk();
});

test('admin can update questionnaire', function () {
    $questionnaire = Questionnaire::factory()->create();
    $title = fake()->sentence();
    $description = fake()->paragraph();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->put(route('admin.questionnaires.update', $questionnaire), [
            'title' => $title,
            'description' => $description,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.questionnaires.edit', $questionnaire));

    $questionnaire->refresh();

    $this->assertSame($title, $questionnaire->title);
    $this->assertSame($description, $questionnaire->description);
});

test('admin can delete questionnaire', function () {
    $questionnaire = Questionnaire::factory()->create();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->delete(route('admin.questionnaires.destroy', $questionnaire));

    $response->assertRedirect(route('admin.questionnaires.index'));

    $this->assertTrue($questionnaire->fresh()->deleted_at !== null);
});

test('admin questionnaire re-index questions screen can be rendered', function () {
    $questionnaire = Questionnaire::factory()->withQuestions()->create();

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->get(route('admin.questionnaires.reindex', $questionnaire));

    $response->assertOk();
});

test('admin can update questions priority', function () {
    $questionnaire = Questionnaire::factory()->withQuestions()->create();
    $questions = $questionnaire->questions;
    $priority_arr = range(1, $questions->count());
    $data = [];

    foreach ($questions as $question) {
        $priority = array_rand($priority_arr);

        $data[] = [
            'id' => $question->id,
            'priority' => $priority_arr[$priority],
        ];

        unset ($priority_arr[$priority]);
    }

    $response = $this
        ->actingAs($this->admin, Admin::GUARD)
        ->put(route('admin.questionnaires.update.priority', $questionnaire), ['question_ids' => $data]);

    $response->assertRedirect(route('admin.questionnaires.reindex', $questionnaire));

    $questionnaire->refresh();
    $updated_questions = $questionnaire->questions;

    foreach ($data as $item) {
        $updated_question = $updated_questions->firstWhere('id', $item['id']);
        $this->assertSame($item['priority'], $updated_question->priority, "Priority did not match for question id {$item['id']}");
    }
});
