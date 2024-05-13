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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->string('player_name');
            $table->string('position');
            $table->string('nationality');
            $table->integer('jersey_number');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
