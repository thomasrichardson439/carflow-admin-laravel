<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function(Blueprint $table) {
            $table->string('owner')->notNull()->default('Car flow');
            $table->integer('seats')->notNull()->default(5);
            $table->string('policy_number')->nullable();
        });

        Schema::table('cars', function(Blueprint $table) {
            $table->string('owner')->notNull()->default(null)->change();
            $table->integer('seats')->notNull()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function(Blueprint $table) {
            $table->dropColumn(['owner', 'seats', 'policy_number']);
        });
    }
}
