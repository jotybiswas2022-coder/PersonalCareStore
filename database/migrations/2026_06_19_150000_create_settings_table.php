<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 10)->default('BDT');
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('vat_percentage', 5, 2)->default(0);
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'currency' => 'BDT',
            'delivery_charge' => 0,
            'vat_percentage' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
