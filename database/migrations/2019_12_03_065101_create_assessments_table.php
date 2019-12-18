<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        $assessments = [
            ['title' => 'ارزیابی محیطی و فیزیکی', 'active' => 1],
            ['title' => 'ارزیابی نیروی کار بر اساس مهارت و تعداد', 'active' => 1],
            ['title' => 'اثبات نمونه کار ها', 'active' => 1],
            ['title' => 'ارزیابی مدارک', 'active' => 1]
        ];
        \Illuminate\Support\Facades\DB::table('assessments')
            ->insert($assessments);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
