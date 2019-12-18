<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailReviewedCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_reviewed_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reviewed_company_id');
            $table->foreign('reviewed_company_id')->references('id')->on('reviewed_companies')->onDelete('cascade');
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
        Schema::dropIfExists('details_reviewed_companies');
    }
}
