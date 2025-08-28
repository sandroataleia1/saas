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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->bigInteger()->unsigned()->autoIncrement();
            $table->string('name');
            $table->string('sku')->unique();
            $table->integer('stock_quantity')->default(0);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price_in_cents')->default(0);
            $table->timestamps();

            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
