<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('delivery_charge', 'delivery_charge_inside');
            $table->decimal('delivery_charge_outside', 10, 2)->default(0)->after('delivery_charge_inside');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('delivery_charge_inside', 'delivery_charge');
            $table->dropColumn('delivery_charge_outside');
        });
    }
};
