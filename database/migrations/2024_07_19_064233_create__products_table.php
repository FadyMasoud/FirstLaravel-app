<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Products', function (Blueprint $table) {
            $table->id();
            $table->integer('id_category');
            $table->integer('id_showroom');
            $table->timestamps();
            $table->string('name');
            $table->string('images');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('speed');
            $table->string('type');
            $table->string('cylinder');
            $table->string('color');
            $table->string('brand');
            $table->string('model');
            $table->decimal('offer', 8, 2);
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
        Schema::dropIfExists('Products');
    }
};
