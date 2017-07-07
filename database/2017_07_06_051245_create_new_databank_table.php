<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateNewDatabankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_databanks', function (Blueprint $table) {
            $table->integer('ref_no');
            $table->date('date');
            $table->string('pp_status');
            $table->string('local_agent');
            $table->string('la_contact');
            $table->string('trade');
            $table->string('company');
            $table->date('offer_letter_received_date');
            $table->date('old_vp_date');
            $table->date('pp_returned_date');
            $table->date('pp_resubmitted_date');
            $table->string('remarks');
            $table->string('db_status');
            $table->timestamps();
            $table->primary('ref_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_databanks');
    }
}
