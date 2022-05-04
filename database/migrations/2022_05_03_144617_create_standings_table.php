<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->unsignedBigInteger('played')->default(0);
            $table->unsignedBigInteger('won')->default(0);
            $table->unsignedBigInteger('draw')->default(0);
            $table->unsignedBigInteger('lost')->default(0);
            $table->bigInteger('goal_difference')->default(0);
            $table->unsignedBigInteger('points')->default(0);
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
        Schema::dropIfExists('standings');
    }
}
