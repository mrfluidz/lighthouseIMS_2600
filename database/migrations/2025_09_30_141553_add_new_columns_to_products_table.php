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
        Schema::table('products', function (Blueprint $table) {
            // Add 'branch_id' column after 'id'
            $table->unsignedBigInteger('branch_id')->after('id');

            // Add 'created_by' column after 'branch_id'
            $table->unsignedBigInteger('created_by')->after('branch_id');

            // Add 'is_active' column after 'created_by'
            $table->boolean('is_active')->default(true)->after('created_by');

            // Add foreign key constraints
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['created_by']);

            // Drop the columns
            $table->dropColumn(['branch_id', 'created_by', 'is_active']);
        });
    }
};
