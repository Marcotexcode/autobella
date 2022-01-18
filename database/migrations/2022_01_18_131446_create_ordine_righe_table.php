<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdineRigheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordine_righe', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ordine_testata_id'); 
            $table->unsignedBigInteger('ricambio_id');
            $table->integer('quantità');
            $table->foreign('ordine_testata_id')->references('id')->on('ordine_testate')->onDelete('cascade');
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
        Schema::dropIfExists('ordine_righe');
    }
}
