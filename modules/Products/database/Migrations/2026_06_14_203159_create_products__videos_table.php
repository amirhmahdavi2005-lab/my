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
        Schema::create('products__videos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('title');
            $table->string('poster')->nullable();
            $table->morphs('user');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products__videos');
    }
};
