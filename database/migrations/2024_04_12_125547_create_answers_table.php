<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('questionnaire_id');
            $table->bigInteger('user_id');
            $table->text('answers');
            $table->integer('result');
            $table->longText('questionnaire_data');
            $table->timestamps();
            $table->softDeletes();

            $table->index('questionnaire_id');
            $table->index('user_id');
            $table->index(['deleted_at', 'updated_at']);
            $table->index(['deleted_at', 'created_at']);
            $table->index(['deleted_at', 'result']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
