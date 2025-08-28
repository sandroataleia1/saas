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
        Schema::create('stock_moviments', function (Blueprint $table) {
            $table->id()->bigInteger()->unsigned()->autoIncrement();
            $table->decimal('quantity', 10, 2);
            $table->enum('type', ['in', 'out']);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->default(1);
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_moviment');
    }
};
