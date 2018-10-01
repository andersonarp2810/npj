<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',254);
            $table->integer('teacher_id')->unsigned();
            $table->enum("status",array('active','inactive'))->default('active');
            $table->integer('qtdPetitions');
            //
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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('groups_teacher_id_foreign');
        });
        Schema::dropIfExists('groups');
    }
}
