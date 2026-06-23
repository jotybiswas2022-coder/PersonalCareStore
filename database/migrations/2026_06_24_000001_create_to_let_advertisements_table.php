<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('to_let_advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('property_type'); // flat, house, sublet, bachelor_mess, office, shop, etc.
            $table->string('division');
            $table->string('district');
            $table->string('area_location');
            $table->text('full_address');
            $table->decimal('monthly_rent', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('property_size', 10, 2)->nullable(); // sqft
            $table->string('tenant_preference'); // family, bachelor, student, etc.
            $table->date('available_from');
            $table->text('description')->nullable();
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->json('images')->nullable(); // store up to 5 image paths
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('to_let_advertisements');
    }
};
