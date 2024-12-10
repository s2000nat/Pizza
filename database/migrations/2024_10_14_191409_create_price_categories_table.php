<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('price_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_categories');
    }
};
