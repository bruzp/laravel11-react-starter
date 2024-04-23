<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW user_answer_rankings AS
            SELECT
                ROW_NUMBER() OVER (ORDER BY max_result DESC) AS rank_no,
                user_id,
                max_result
            FROM (
                SELECT user_id, MAX(result) AS max_result
                FROM answers
                WHERE deleted_at IS NULL
                GROUP BY user_id
            ) AS results
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS user_answer_rankings");
    }
};
