<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_tlc_license')->default(false);
            $table->boolean('is_photo_id')->default(false);
            $table->text('ridesharing_apps')->nullable();
            $table->enum('step', [1, 2, 3])->default(1);
            $table->enum('status', ['rejected', 'pending', 'approved'])
                  ->default('pending');
            $table->boolean('uber_approved')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
