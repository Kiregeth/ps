<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewVrFlownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_vr_flowns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_no');
            $table->date('date');
            $table->string('wp_expiry');
            $table->date('visa_return_date');
            $table->date('visa_issue_date');
            $table->date('visa_expiry_date');
            $table->string('supply_agent');
            $table->date('flown_date');
            $table->integer('demand_no');
            $table->integer('visa_no');
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
        Schema::dropIfExists('new_vr_flowns');
    }
}
