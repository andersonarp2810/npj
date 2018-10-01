<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoubleStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('double_students', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('student_id')->unsigned();
          $table->integer('student2_id')->unsigned();
          $table->integer('group_id')->unsigned();
          $table->enum("status",array('active','inactive'))->default('active');
          $table->integer('qtdPetitions');
          //
          $table->foreign('student_id')->references('id')->on('humans');
          $table->foreign('student2_id')->references('id')->on('humans');
          $table->foreign('group_id')->references('id')->on('groups');

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
         Schema::dropIfExists('double_students');
     }
}
