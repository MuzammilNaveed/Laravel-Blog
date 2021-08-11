<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('route')->nullable();
            $table->integer('sequence')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('is_active')->default('0');
            $table->string('role_id')->nullable();
            $table->integer('feature_type')->nullable();
            $table->string('menu_icon')->nullable();
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
        Schema::dropIfExists('features');
    }
}
