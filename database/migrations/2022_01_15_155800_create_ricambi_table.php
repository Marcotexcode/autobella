<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRicambiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ricambi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('fornitore_id');
            $table->text('descrizione');
            $table->decimal('prezzo', 4,2);
            $table->foreign('categoria_id')->references('id')->on('categorie')->onDelete('cascade');
            $table->foreign('fornitore_id')->references('id')->on('fornitori')->onDelete('cascade');

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
        Schema::dropIfExists('ricambi');
    }
}
