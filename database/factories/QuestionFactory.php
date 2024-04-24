<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(),
            'choices' => serialize([
                fake()->sentence(),
                fake()->sentence(),
                fake()->sentence(),
            ]),
            'answer' => rand(0, 2),
            'priority' => 1,
        ];
    }

    public function withQuestionnaire(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'questionnaire_id' => Questionnaire::factory(),
            ];
        });
    }
}
