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
            $table->string('name');
            $table->string('avatar')->nullable()->default('logo.png');
            $table->string('barra')->nullable();
            $table->string('unitSelect')->nullable()->default('false');
            $table->string('unit')->nullable()->default('un');
            $table->integer('stock')->nullable()->default(0);
            $table->double('costUnit',11,6)->nullable()->default(0);
            $table->double('unitSale',11,6)->nullable()->default(0);
            $table->double('priceUnit',11,6)->nullable()->default(0);
            $table->string('visible')->default('yes');
            $table->string('description')->nullable();
            $table->foreignId('shop_id')->nullable()->constrained('shops');
            $table->foreignId('category_id')->nullable()->constrained('categories');
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
        Schema::dropIfExists('products');
    }
};
