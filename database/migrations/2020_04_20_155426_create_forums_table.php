<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('forums')) {
            Schema::create('forums', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('title');
                $table->text('message')->nullable();
                $table->json('users')->nullable();
                $table->boolean('private')->default(false);
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('forums');
    }
}
