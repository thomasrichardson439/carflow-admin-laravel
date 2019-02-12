<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeviceTokenIdInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->renameColumn('device_token_id', 'device_token_ids');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->text('device_token_ids')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->renameColumn('device_token_ids', 'device_token_id');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->int('device_token_id')->change();
        });
    }
}
