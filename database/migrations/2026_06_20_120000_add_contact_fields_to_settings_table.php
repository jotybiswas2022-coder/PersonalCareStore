<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('contact_phone')->nullable()->after('vat_percentage');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->text('contact_address')->nullable()->after('contact_email');
            $table->string('contact_hours')->nullable()->after('contact_address');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['contact_phone', 'contact_email', 'contact_address', 'contact_hours']);
        });
    }
};
