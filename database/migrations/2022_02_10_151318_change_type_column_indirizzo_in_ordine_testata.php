<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnIndirizzoInOrdineTestata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordine_testate', function (Blueprint $table) {
            $table->string('indirizzo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordine_testate', function (Blueprint $table) {
            $table->string('indirizzo')->change();
        });
    }
}
