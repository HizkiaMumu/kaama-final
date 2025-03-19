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
        Schema::create('frame_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('frame_id')->unsigned();
            $table->integer('x');
            $table->integer('y');
            $table->integer('width');
            $table->timestamps();

            $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frame_positions');
    }
};
