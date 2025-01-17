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
	    Schema::create('students', function (Blueprint $table) {
		    $table->string('nim', 9)->primary();
		    $table->string('name', 100);
		    $table->string('major', 100);
		    $table->string('study_program', 150);
		    $table->string('year', 4);
		    $table->string('email', 255);
		    $table->string('status', 20);
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
