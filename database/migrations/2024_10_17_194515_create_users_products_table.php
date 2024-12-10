<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products');
            $table->timestamps();
            $table->integer('quantity')->default(1);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_products');
    }
};
