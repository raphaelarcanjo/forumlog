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
                $table->json('users')->nullable();
                $table->boolean('private')->default(false);
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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