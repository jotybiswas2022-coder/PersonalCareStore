<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('stock_reserved_at')->nullable()->after('cancelled_by')
                ->comment('Set when the order deducted product stock, so cancellation restores it once.');
        });

        // Delivered orders already had their stock deducted by the old
        // deduct-on-delivery flow, so mark them as reserved.
        DB::table('orders')
            ->where('status', 'delivered')
            ->update(['stock_reserved_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stock_reserved_at');
        });
    }
};
