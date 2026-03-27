<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_profiles', function (Blueprint $table): void {
            $table->string('whatsapp_message', 1000)->nullable()->after('welcome_text');
            $table->string('product_inquiry_message', 1000)->nullable()->after('whatsapp_message');
        });

        DB::table('business_profiles')
            ->whereNull('whatsapp_message')
            ->update(['whatsapp_message' => 'Hola, quiero hacer una consulta sobre {business_name}.']);

        DB::table('business_profiles')
            ->whereNull('product_inquiry_message')
            ->update(['product_inquiry_message' => 'Hola, quiero consultar por {product_name} de {business_name}.']);
    }

    public function down(): void
    {
        Schema::table('business_profiles', function (Blueprint $table): void {
            $table->dropColumn([
                'whatsapp_message',
                'product_inquiry_message',
            ]);
        });
    }
};
