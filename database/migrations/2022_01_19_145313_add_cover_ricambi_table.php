<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoverRicambiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ricambi', function (Blueprint $table) {
            $table->string('cover')->nullable()->after('prezzo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ricambi', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
}
