<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelloRicambioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modello_ricambio', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('modello_id');
            $table->unsignedBigInteger('ricambio_id');
            $table->foreign('modello_id')->references('id')->on('modelli')->onDelete('cascade');
            $table->foreign('ricambio_id')->references('id')->on('ricambi')->onDelete('cascade');

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
        Schema::dropIfExists('modello_ricambios');
    }
}
