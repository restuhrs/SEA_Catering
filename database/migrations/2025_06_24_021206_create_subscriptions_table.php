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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('plan');
            $table->json('meal_types'); // simpan array menggunakan json karena > 1
            $table->json('delivery_days'); // simpan array menggunakan json karena > 1
            $table->text('allergies')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
