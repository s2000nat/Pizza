<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('apartment')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->boolean('deleted')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
