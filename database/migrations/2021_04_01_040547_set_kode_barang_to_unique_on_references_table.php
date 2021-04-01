<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetKodeBarangToUniqueOnReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reference_storages', function (Blueprint $table) {
            //
            $table->unique('kode_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reference_storages', function (Blueprint $table) {
            //
            $table->dropUnique('kode_barang');
        });
    }
}
