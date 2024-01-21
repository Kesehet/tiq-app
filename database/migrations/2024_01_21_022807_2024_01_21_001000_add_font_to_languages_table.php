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
        Schema::table('languages', function (Blueprint $table) {
            $table->string('font')->nullable()->after('code'); // Adding 'font' column after 'code'
        });
    }

    public function down()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('font'); // Dropping 'font' column if the migration is rolled back
        });
    }
};
