<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCratedByToStringOnReferenceStorage extends Migration
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
            $table->string('created_by')->change();
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
            $table->unsignedBigInteger('created_by')->change();
        });
    }
}
