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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();                                     // primary key
            $table->foreignId('user_id')                      // who placed the order
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('order_number')->unique();         // e.g. CT-abc123
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            $table->enum('order_status', ['pending','completed','cancelled'])
                  ->default('pending');
            $table->enum('payment_status', ['unpaid','paid','refunded'])
                  ->default('unpaid');
            $table->string('track_order')->nullable();        // your tracking code or URL slug
            $table->timestamps();                             // created_at & updated_at    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
