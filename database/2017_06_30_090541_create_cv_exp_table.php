<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCvExpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_exps', function (Blueprint $table) {
            $table->integer('ref_no');
            $table->integer('exp_id');
            $table->string('name_of_company');
            $table->string('designation');
            $table->string('start_year');
            $table->string('end_year');
            $table->string('country');
            $table->string('reason_for_leave');
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
        Schema::dropIfExists('cv_exps');
    }
}
