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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullabl();

            $table->string('meta_title')->nullable();
            $table->mediumText('meta_keyword')->nullable();
            $table->mediumText('meta_description')->nullable();

            $table->integer('quantity')->nullable();
            $table->integer('selling_price')->nullable();
            $table->integer('original_price')->nullable();
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->integer('id_category');

            $table->tinyInteger('featured')->default(0)->comment("La valeur par defaut est 0");
            $table->tinyInteger('popular')->default(0)->comment("La valeur par defaut est 0");
            $table->tinyInteger('status')->default(0)->comment("La valeur par defaut est 0");
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
        Schema::dropIfExists('Product');
    }
};
