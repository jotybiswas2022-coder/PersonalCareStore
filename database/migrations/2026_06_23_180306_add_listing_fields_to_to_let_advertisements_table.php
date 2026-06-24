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
        Schema::table('to_let_advertisements', function (Blueprint $table) {
            $table->string('listing_type')->nullable()->after('property_type');
            $table->integer('floor_number')->nullable()->after('bathrooms');
            $table->integer('total_floors')->nullable()->after('floor_number');
            $table->string('furnishing')->nullable()->after('property_size');
            $table->decimal('security_deposit', 10, 2)->nullable()->after('monthly_rent');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->string('preferred_contact_method')->nullable()->after('contact_email');
        });
    }

    public function down(): void
    {
        Schema::table('to_let_advertisements', function (Blueprint $table) {
            $table->dropColumn([
                'listing_type',
                'floor_number',
                'total_floors',
                'furnishing',
                'security_deposit',
                'contact_email',
                'preferred_contact_method',
            ]);
        });
    }
};
