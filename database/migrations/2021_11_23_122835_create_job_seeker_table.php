<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSeekerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_seeker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email',250)->unique();
            $table->string('password');
            $table->integer('phone');
            $table->string('experience');
            $table->string('notice_period');
            $table->string('skills');
            $table->string('location');
            $table->string('resume');
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
        Schema::dropIfExists('job_seeker');
    }
}
