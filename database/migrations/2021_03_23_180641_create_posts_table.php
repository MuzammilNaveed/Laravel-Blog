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
            $table->string("title")->nullable();
            $table->string("slug")->nullable();
            $table->integer("cat_id")->nullable();
            $table->string("tags_id")->nullable();
            $table->integer("status")->default('0');
            $table->string("image")->nullable();
            $table->longText('description')->nullable();
            $table->string("meta_title")->nullable();
            $table->string("meta_tags")->nullable();
            $table->longText('meta_description')->nullable();
            $table->integer("created_by")->nullable();
            $table->integer("is_deleted")->default('0');
            $table->integer("view_count")->default('0');
            $table->integer("deleted_by")->nullable();
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
        Schema::dropIfExists('posts');
    }
}
