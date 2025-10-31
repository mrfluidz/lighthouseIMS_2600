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
        Schema::create('product_activity_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_log_type_id'); // links to product_log_types
            $table->unsignedBigInteger('branch_id');

            $table->integer('initial_stocks');
            $table->integer('restock_qty')->nullable();
            $table->integer('defective_qty')->nullable();
            $table->integer('sold_qty')->nullable();
            $table->integer('add_qty')->nullable();
            $table->integer('latest_stocks');

            $table->text('returned_by')->nullable();
            $table->unsignedBigInteger('product_id_replaced')->nullable();

            $table->string('stock_status')->nullable()->comment('increase or decrease stock has update');
            $table->decimal('initial_price', 15, 2)->nullable();
            $table->decimal('before_price', 15, 2)->nullable();
            $table->string('price_status')->nullable()->comment('increase or decrease price has update');

            $table->unsignedBigInteger('created_by');

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_log_type_id')->references('id')->on('product_log_types')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id_replaced')->references('id')->on('products')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            // Default Laravel timestamps
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_activity_logs');
    }
};
