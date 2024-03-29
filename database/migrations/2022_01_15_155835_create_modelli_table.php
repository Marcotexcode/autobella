<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelli', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('marca_id');
            $table->string('nome');
            $table->string('anno_commercializzazione');
            $table->foreign('marca_id')->references('id')->on('marche')->onDelete('cascade');

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
        Schema::dropIfExists('modelli');
    }
}
