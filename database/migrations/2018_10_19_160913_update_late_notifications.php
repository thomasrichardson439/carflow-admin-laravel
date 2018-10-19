<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLateNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('late_notifications', function (Blueprint $table) {
            $table->integer('delay_minutes')->nullable()->change();
            $table->string('photo_s3_link')->nullable()->change();
            $table->string('reason', 1000)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('late_notifications', function (Blueprint $table) {
            $table->integer('delay_minutes')->notNull()->change();
            $table->string('photo_s3_link')->notNull()->change();
            $table->string('reason', 1000)->notNull()->change();
        });
    }
}
