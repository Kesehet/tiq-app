<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create quizzes table
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create questions table
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->timestamps();
        });

        // Create translations table
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('language');
            $table->text('translated_text');
            $table->timestamps();
        });

        // Create options table
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('option_text');
            $table->boolean('is_correct');
            $table->timestamps();
        });

        // Create translation_options table
        Schema::create('translation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->string('language');
            $table->text('translated_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translation_options');
        Schema::dropIfExists('options');
        Schema::dropIfExists('translations');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
