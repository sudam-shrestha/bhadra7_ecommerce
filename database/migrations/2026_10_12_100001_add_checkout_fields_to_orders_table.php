<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cod', 'khalti'])->default('cod')->after('payment_status');
            $table->text('address')->nullable()->after('contact_no');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->after('qty'); // final unit price at purchase time
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'address']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
