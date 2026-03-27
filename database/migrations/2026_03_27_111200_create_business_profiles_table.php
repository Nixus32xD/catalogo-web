<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('business_name');
            $table->string('logo_path')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->string('short_description', 500);
            $table->string('address');
            $table->string('whatsapp', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('business_hours');
            $table->text('welcome_text');
            $table->string('primary_color', 7)->default('#0f766e');
            $table->string('secondary_color', 7)->default('#f59e0b');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
