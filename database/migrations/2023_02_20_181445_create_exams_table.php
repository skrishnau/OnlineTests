<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');

            $table->unsignedBigInteger('paper_id');
            $table->foreign('paper_id')->references('id')->on('papers');

            $table->smallInteger('type'); // 1: anonymous or 2: signed users 
            $table->smallInteger('display'); // 1: all in one page, 2: one at a time, 3: one at a time with grouping

            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->smallInteger('duration_in_mins')->nullable();
            $table->string('link_id')->unique(); // generated id for the paper examination to be given to students

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
        Schema::dropIfExists('exams');
    }
}
