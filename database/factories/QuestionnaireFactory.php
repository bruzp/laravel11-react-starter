<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionnaire>
 */
class QuestionnaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
        ];
    }

    public function withQuestions(int $count = 10): Factory
    {
        return $this->has(Question::factory()->count($count), 'questions');
    }
}
