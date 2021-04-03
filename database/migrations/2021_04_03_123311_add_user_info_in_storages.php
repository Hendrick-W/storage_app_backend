<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserInfoInStorages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storages', function (Blueprint $table) {
            //
            $table->integer('user_id')->after('storage_type');
            $table->string('user_role')->after('storage_type');
            $table->string('created_by')->after('storage_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storages', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
            $table->dropColumn('user_role');
            $table->dropColumn('created_by');
        });
    }
}
