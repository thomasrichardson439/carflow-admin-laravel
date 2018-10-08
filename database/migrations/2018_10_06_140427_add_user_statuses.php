<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE users 
            CHANGE COLUMN status status 
            ENUM(
                'rejected',
                'pending',
                'approved',
                'pending_profile',
                'rejected_profile'
            ) 
            NOT NULL DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE users 
            CHANGE COLUMN status status 
            ENUM(
                'rejected',
                'pending',
                'approved',
                'pending_profile',
                'rejected_profile'
            ) 
            NOT NULL DEFAULT 'pending'
        ");
    }
}
