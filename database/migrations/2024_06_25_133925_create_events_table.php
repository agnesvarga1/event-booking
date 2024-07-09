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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name',256)->unique();
            $table->string("description")->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('meeting_room_id')->nullable();
            $table->foreign('meeting_room_id')->references('id')->on('meeting_rooms')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
