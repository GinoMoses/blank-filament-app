<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_tests', function (Blueprint $table) {
            $table->string('generation_type')->nullable()->after('number_of_questions');
            $table->json('category_ids')->nullable()->after('generation_type');
            $table->json('difficulty_levels')->nullable()->after('category_ids');
            $table->boolean('is_auto_generated')->default(false)->after('difficulty_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_tests', function (Blueprint $table) {
            $table->dropColumn(['category_ids', 'difficulty_levels', 'is_auto_generated']);
        });
    }
};
