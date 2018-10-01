<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content',1000);
            $table->integer('human_id')->unsigned();//id do human que faz o comentario
            $table->integer('petition_id')->unsigned();//id da petição

            $table->foreign('human_id')->references('id')->on('humans');
            $table->foreign('petition_id')->references('id')->on('petitions')->onDelete('cascade');;
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_human_id_foreign');
            $table->dropForeign('comments_petition_id_foreign');
        });
        Schema::dropIfExists('comments');
    }
}
