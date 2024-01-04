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
        // Update 'translations' table
        Schema::table('translations', function (Blueprint $table) {
            // Drop the existing 'language' column
            $table->dropColumn('language');
            // Add 'language_id' column and foreign key
            $table->unsignedBigInteger('language_id')->after('question_id'); // Adjust 'some_column' as needed
            $table->foreign('language_id')->references('id')->on('languages');
        });

        // Update 'translation_options' table
        Schema::table('translation_options', function (Blueprint $table) {
            // Drop the existing 'language' column
            $table->dropColumn('language');
            // Add 'language_id' column and foreign key
            $table->unsignedBigInteger('language_id')->after('option_id'); // Adjust 'some_column' as needed
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    public function down()
    {
        // Revert 'translations' table changes
        Schema::table('translations', function (Blueprint $table) {
            // Drop the foreign key and 'language_id' column
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
            // Re-add the 'language' column
            $table->string('language')->after('question_id'); // Adjust 'some_column' as needed
        });

        // Revert 'translation_options' table changes
        Schema::table('translation_options', function (Blueprint $table) {
            // Drop the foreign key and 'language_id' column
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
            // Re-add the 'language' column
            $table->string('language')->after('option_id'); // Adjust 'some_column' as needed
        });
    }
};
