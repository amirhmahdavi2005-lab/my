<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products__price_variations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('price1');
            $table->integer('price2');
            $table->smallInteger('preparation_time')->default(0);
            $table->integer('product_count')->nullable();
            $table->smallInteger('max_product_cart')->nullable();
            $table->nullableMorphs('param1');
            $table->nullableMorphs('param2');
            $table->nullableMorphs('param3');
            $table->string('sku')->nullable();
            $table->string('sender')->default('self');
            $table->string('selected_buy_box')->default('no');
            $table->smallInteger('status')->default(1);
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->bigInteger('seller_id')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products__price_variations');
    }
};
