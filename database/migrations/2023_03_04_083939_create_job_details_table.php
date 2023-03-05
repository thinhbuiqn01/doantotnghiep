<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('require_job');
            $table->string('type_pay_salary');
            $table->string('location_jobs');
            $table->string('email_take_cv');
            $table->integer('job_id')->unsigned()->nullable();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');

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
        Schema::dropIfExists('job_details');
    }
};
