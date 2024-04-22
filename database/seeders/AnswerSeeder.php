<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Questionnaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $questionnaires = Questionnaire::with('questions')->get();

        $limit = 20000;
        $chunk_size = 2000;
        $data = [];

        for ($i = 0; $i < $limit; ++$i) {
            $questionnaire = $questionnaires->random();

            if ($questionnaire->questions->isEmpty()) {
                continue;
            }

            $questions = $questionnaire->questions;
            $answers = [];
            $total = $questions->count();
            $check = 0;

            foreach ($questions as $question) {
                $choices = unserialize($question->choices);
                $user_answer = array_rand($choices);
                $answers[$question->id] = $user_answer;

                if ($user_answer === $question->answer) {
                    $check++;
                }
            }

            $data[] = [
                'questionnaire_id' => $questionnaire->id,
                'user_id' => $users->random()->id,
                'answers' => serialize($answers),
                'result' => $check ? ($check / $total) * 100 : $check,
                'questionnaire_data' => serialize($questions->toArray()),
                'created_at' => fake()->dateTimeBetween('-5 years', 'now'),
                'updated_at' => fake()->dateTimeBetween('-5 years', 'now'),
            ];
        }

        $chunks = array_chunk($data, $chunk_size);

        foreach ($chunks as $chunk) {
            DB::table('answers')->insert($chunk);
        }
    }
}
