<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone_number');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', [
                'pending',
                'in preparation',
                'out for delivery',
                'delivered',
                'cancelled'
            ])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
