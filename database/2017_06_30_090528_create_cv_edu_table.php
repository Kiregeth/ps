<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCvEduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_edus', function (Blueprint $table) {
            $table->integer('ref_no');
            $table->integer('edu_no');
            $table->string('qualification');
            $table->string('name_of_institution');
            $table->date('year_of_passing');
            $table->string('grades_obtained');
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
        Schema::dropIfExists('cv_edus');
    }
}
