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
	    Schema::create('attendance', function (Blueprint $table) {
		    $table->id('attendance_id'); // Primary Key
		    $table->string('student', 9); // Foreign Key ke students
		    $table->unsignedBigInteger('workshop_id'); // Foreign Key ke workshops
		    $table->dateTime('check_in_time')->nullable(); // Waktu Check-In
		    $table->dateTime('check_out_time')->nullable(); // Waktu Check-Out
		    $table->timestamps();
		    
		    // Foreign Key Constraints
		    $table->foreign('student')->references('nim')->on('students')->cascadeOnDelete();
		    $table->foreign('workshop_id')->references('workshop_id')->on('workshops')->cascadeOnDelete();
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
