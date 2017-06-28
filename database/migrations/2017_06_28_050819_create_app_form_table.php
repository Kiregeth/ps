<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_forms', function (Blueprint $table) {
            $table->increments('ref_no');
            $table->string('name');
            $table->string('position');
            $table->string('telephone_no');
            $table->string('mobile_no');
            $table->string('religion');
            $table->string('address');
            $table->string('contact_address');
            $table->string('email');
            $table->string('qualification');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('spouse_name');
            $table->string('passport_no');
            $table->string('place_of_issue');
            $table->string('date_of_issue');
            $table->string('date_of_expiry');
            $table->integer('height_feet');
            $table->integer('height_inch');
            $table->integer('weight');
            $table->string('parent_name');
            $table->text('prior_experience');
            $table->text('document_list');
            $table->string('photo');
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
        Schema::dropIfExists('app_forms');
    }
}
