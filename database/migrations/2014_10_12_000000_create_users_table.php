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
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->text('ridesharing_apps')->nullable();
            $table->enum('status', ['rejected', 'pending', 'approved'])
                  ->default('pending');
            $table->boolean('documents_uploaded')->default(false);
            $table->boolean('ridesharing_approved')->default(false);
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
