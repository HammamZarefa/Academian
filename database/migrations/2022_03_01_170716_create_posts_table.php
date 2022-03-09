<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('author_id');
            $table->string('title');
            $table->string('slug');
            $table->string('cover');
            $table->longText('body');
            $table->string('keyword');
            $table->string('meta_desc');
            $table->integer('views')->default(0);
            $table->enum('status', ['PUBLISH','DRAFT','PENDING']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
