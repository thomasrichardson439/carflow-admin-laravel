<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReceiptDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_receipts', function (Blueprint $table) {
            $table->renameColumn('description', 'location');
            $table->dateTime('receipt_date')->notNull()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_receipts', function (Blueprint $table) {
            $table->renameColumn('location', 'description');
            $table->date('receipt_date')->notNull()->change();
        });
    }
}
