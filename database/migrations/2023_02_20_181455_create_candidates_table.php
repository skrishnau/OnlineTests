<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams');
            
            //$table->string('link_code')->nullable(); // V2

            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();

            $table->string('candidate_name')->nullable();
            $table->string('candidate_id')->nullable(); // if there's id then store it
            $table->string('candidate_email')->nullable(); // if there's id then store it
            
            // TODO: V2 - need to implement - examination by logged in users
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');


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
        Schema::dropIfExists('candidates');
    }
}
