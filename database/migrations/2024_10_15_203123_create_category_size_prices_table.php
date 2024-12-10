<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_size_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_category_id')
                ->default(1)
                ->constrained('price_categories');
            $table->foreignId('size_id')
                ->default(1)
                ->constrained('sizes');
            $table->float('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_size_prices');
    }
};
