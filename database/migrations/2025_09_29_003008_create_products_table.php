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
            $table->id();
            $table->string('code')->unique();
            $table->string('product_name')->unique();

            // Define foreign key column and constraint
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->text('details'); // For long text (up to 1000 characters with validation)
            $table->string('supplier');
            $table->string('brand');
            $table->integer('stocks');
            $table->string('priceCode');
            $table->double('price', 8, 2); // Precision: 8 digits total, 2 decimal places
            $table->timestamps();
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
