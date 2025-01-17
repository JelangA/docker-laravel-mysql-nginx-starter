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
	    Schema::create('workshops', function (Blueprint $table) {
		    $table->id('workshop_id'); // Primary Key
		    $table->string('title', 150);
		    $table->text('description')->nullable();
		    $table->dateTime('start_time');
		    $table->dateTime('end_time');
		    $table->string('location', 255)->nullable();
		    $table->timestamps(); // created_at dan updated_at
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
