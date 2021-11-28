<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_job', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');
            $table->string('photo');
            $table->string('canditate_name');
            $table->string('experience');
            $table->integer('phone');
            $table->string('job_title');
            $table->string('resume');
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
        Schema::dropIfExists('applied_job');
    }
}
