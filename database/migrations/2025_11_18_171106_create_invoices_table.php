<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_num')->unique();
            $table->string('customer');
            $table->dateTime('invoice_datetime');

            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            $table->boolean('is_draft')->default(false);
            $table->unsignedBigInteger('branch_id');
            $table->boolean('is_active')->default(true);

            // auto timestamps
            $table->timestamps(); // created_at, updated_at

            // created by / updated by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
