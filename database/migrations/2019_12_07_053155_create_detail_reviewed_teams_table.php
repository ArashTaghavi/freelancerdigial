<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailReviewedTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_reviewed_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reviewed_team_id');
            $table->foreign('reviewed_team_id')->references('id')->on('reviewed_teams')->onDelete('cascade');
            $table->integer('type');
            $table->integer('score')->default(0);
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
        Schema::dropIfExists('detail_reviewed_teams');
    }
}
