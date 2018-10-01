<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title',1000);
            $table->longText('content',6000);
            $table->integer('teacher_id')->unsigned();//id do professor
            $table->enum("status",array('active','inactive'))->default('active');

            $table->foreign('teacher_id')->references('id')->on('humans');
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
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign('templates_teacher_id_foreign');
        });
        Schema::dropIfExists('templates');
    }
}
