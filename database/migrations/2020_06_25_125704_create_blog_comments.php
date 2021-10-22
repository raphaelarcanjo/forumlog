<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_comments')) {
            Schema::create('blog_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('comment_by');
                $table->string('comment');
                $table->integer('post');
                $table->timestamps();
                $table->foreign('comment_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('blog_comments');
    }
}
