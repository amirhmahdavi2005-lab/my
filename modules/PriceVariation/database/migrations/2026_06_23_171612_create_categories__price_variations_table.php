<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories__price_variation', function (Blueprint $table) {
            $table->id();
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('item3')->nullable();  // ← item2 رو به item3 تغییر دادم
            $table->bigInteger('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories__price_variation');
    }
};
