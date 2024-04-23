<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('admin_id');
            $table->index('title');

            $table->index(['deleted_at', 'title']);
            $table->index(['deleted_at', 'updated_at']);
            $table->index(['deleted_at', 'created_at']);
        });

        DB::statement("CREATE INDEX deleted_at_description_index ON questionnaires (deleted_at,description(191))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
