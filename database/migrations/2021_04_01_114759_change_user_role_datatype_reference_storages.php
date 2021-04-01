<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserRoleDatatypeReferenceStorages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('reference_storages', function (Blueprint $table) {
            //
            $table->integer('user_role')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('reference_storages', function (Blueprint $table) {
            //
            $table->string('user_role')->change();
        });
    }
}
