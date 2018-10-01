<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('petitions', function (Blueprint $table) {
          $table->increments('id');
          $table->longText('description',1000);

          $table->longText('content',9000);
          $table->enum("student_ok",array('true','false'))->nullable();
          $table->enum("teacher_ok",array('true','false'))->nullable();
          $table->enum("defender_ok",array('true','false'))->nullable();
          $table->integer('template_id')->unsigned();//referencia de qual template é
          $table->integer('defender_id')->nullable();//referencia qual defensor pegou e avaliou a peticao
          $table->integer('doubleStudent_id')->unsigned();//referencia que foi a dupla que fez a petiçao
          $table->integer('group_id');//referencia a qual grupo pertence
          $table->integer('version');
          $table->enum("visible",array('true','false'));//controle de versão(versão utilizada fica true, versão nao utiilzada fica false)
          $table->integer('petitionFirst')->nullable();


          $table->foreign('template_id')->references('id')->on('templates');
          $table->foreign('doubleStudent_id')->references('id')->on('double_students');

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
        Schema::dropIfExists('petitions');
    }
}
