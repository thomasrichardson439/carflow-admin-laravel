<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserProfileUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->notNull();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        DB::statement("
            UPDATE users SET status = 'pending' 
            WHERE status IN ('pending_profile', 'rejected_profile')
        ");

        DB::statement("
            ALTER TABLE users 
            CHANGE COLUMN status status 
            ENUM(
                'rejected',
                'pending',
                'approved'              
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
        Schema::dropIfExists('user_profile_updates');

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
