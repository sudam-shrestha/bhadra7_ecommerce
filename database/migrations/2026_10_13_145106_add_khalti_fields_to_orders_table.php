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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('khalti_pidx')->nullable()->unique()->after('payment_method');
            $table->string('khalti_transaction_id')->nullable()->after('khalti_pidx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['khalti_pidx']);
            $table->dropColumn(['khalti_pidx', 'khalti_transaction_id']);
        });
    }
};
