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
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->string('title');
            $table->text('text');
            $table->string('slug');
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->foreign('cover_id')->references('id')->on('covers')->onDelete('SET NULL');
            //$table->foreignId('cover_id')->constrained()->default('0')->onDelete('cascade');
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
