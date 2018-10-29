<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assisteds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rg')->nullable();
            $table->string('cpf')->nullable();
            $table->string('telefone')->nullable();

            $table->string('status')->default('active'); // active ou inactive
            

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
        Schema::dropIfExists('assisteds');
    }
}
