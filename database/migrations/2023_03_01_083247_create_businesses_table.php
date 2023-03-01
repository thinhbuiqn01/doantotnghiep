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
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name');
            $table->string('scales');
            $table->string('description');
            $table->string('link_website');
            $table->string('image');
            $table->string('task');
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id');
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
        Schema::dropIfExists('businesses');
    }
};
