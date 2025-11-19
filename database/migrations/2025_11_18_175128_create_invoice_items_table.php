<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->boolean('is_draft')->default(false);
            $table->integer('quantity');
            $table->decimal('discount_price', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2);
            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_on')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_on')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};
