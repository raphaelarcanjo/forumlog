<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('tagname')->unique();
                $table->json('phones')->nullable();
                $table->string('cep');
                $table->string('address');
                $table->string('complement');
                $table->string('suburb');
                $table->string('city');
                $table->string('state');
                $table->string('country');
                $table->date('birth');
                $table->string('photo')->default('no-image.jpg');
                $table->boolean('ban')->default(false);
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }
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
