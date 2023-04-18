<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->references('id')->on('candidates');

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unsignedBigInteger('selected_option_id')->nullable();
            $table->foreign('selected_option_id')->references('id')->on('options');
            
            $table->text('answer_text')->nullable(); // answer in text format

            // need to have 'is_correct' column in this table too.
            //  cause for answer_text the teacher marks the correctness of answer later so we need to store it 
            //  also for selected_option_id, it best to indicate the correctness in this table such 
            //    that we need to query options table to get scores
            // Values: null-> not graded yet, 1-> correct answer, 0 -> incorrect answer
            $table->boolean('is_correct')->nullable();

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
        Schema::dropIfExists('answers');
    }
}
