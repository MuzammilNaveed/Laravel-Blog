<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('target')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('position')->default('0')->nullable();
            $table->integer('status')->nullable();
            $table->integer('menu_id')->nullable();            
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
        Schema::dropIfExists('menu_items');
    }
}
