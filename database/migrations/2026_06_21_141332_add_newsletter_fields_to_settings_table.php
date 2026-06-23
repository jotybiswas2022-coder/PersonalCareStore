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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('newsletter_heading')->nullable()->default('Stay in the Loop');
            $table->text('newsletter_text')->nullable()->default('Subscribe to get notified about new products, exclusive offers, and care tips delivered to your inbox.');
            $table->string('newsletter_placeholder')->nullable()->default('Enter your email address');
            $table->string('newsletter_button_text')->nullable()->default('Subscribe');
            $table->boolean('newsletter_enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'newsletter_heading',
                'newsletter_text',
                'newsletter_placeholder',
                'newsletter_button_text',
                'newsletter_enabled',
            ]);
        });
    }
};
