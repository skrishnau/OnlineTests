<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paper_id');
            $table->foreign('paper_id')->references('id')->on('papers');

            $table->longText('description'); // question description
            $table->smallInteger('type'); // if '1' then answers is given as multi-choice select, else if '2' then answers will be written as text
            $table->string('tag', 20)->nullable(); // for searches only
            $table->string('group')->nullable(); // v2. to group the questions 
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
        Schema::dropIfExists('questions');
    }
}
