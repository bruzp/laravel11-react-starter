<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Questionnaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::find(1);
        $data = [];
        $limit = 50;
        $chunk_size = 2000;

        for ($i = 0; $i < $limit; ++$i) {
            $data[] = [
                'admin_id' => $admin->id,
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'created_at' => fake()->dateTimeBetween('-5 years', 'now'),
                'updated_at' => fake()->dateTimeBetween('-5 years', 'now'),
            ];
        }

        DB::table('questionnaires')->insert($data);

        $questionnaires = Questionnaire::all()->modelKeys();
        $data = [];

        for ($i = 0; $i < count($questionnaires); ++$i) {
            $ranges = [10, 20, 30, 40, 50];
            $random = $ranges[array_rand($ranges)];

            for ($x = 0; $x < $random; $x++) {
                $choices = [];

                $answer_ranges = [3, 4, 5];
                $random_ar = $answer_ranges[array_rand($answer_ranges)];

                for ($y = 0; $y < $random_ar; $y++) {
                    $choices[] = fake()->sentence();
                }

                $data[] = [
                    'questionnaire_id' => $questionnaires[$i],
                    'question' => fake()->sentence() . '?',
                    'choices' => serialize($choices),
                    'answer' => array_rand($choices),
                    'priority' => $x + 1,
                    'created_at' => fake()->dateTimeBetween('-5 years', 'now'),
                    'updated_at' => fake()->dateTimeBetween('-5 years', 'now'),
                ];
            }
        }

        $chunks = array_chunk($data, $chunk_size);

        foreach ($chunks as $chunk) {
            DB::table('questions')->insert($chunk);
        }
    }
}
