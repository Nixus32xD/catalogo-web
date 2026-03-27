<?php

namespace Database\Seeders;

use App\Models\BusinessProfile;
use Illuminate\Database\Seeder;

class StoreLocationSeeder extends Seeder
{
    public function run(): void
    {
        $profile = BusinessProfile::current();

        collect([
            [
                'name' => 'Sucursal Maipu Centro',
                'address' => 'Direccion de la sucursal Maipu Centro',
                'phone' => '+54 11 0000 0001',
                'whatsapp' => '+54 9 11 0000 0001',
                'email' => 'maipu@comercio-demo.com',
                'business_hours' => 'Lunes a sabado de 9:00 a 18:00',
                'map_embed_url' => 'https://www.google.com/maps?q=Maipu%20Centro%20Mendoza&output=embed',
                'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Maipu+Centro+Mendoza',
                'notes' => 'Punto de venta principal para la demo.',
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sucursal Lulunta',
                'address' => 'Direccion de la sucursal Lulunta',
                'phone' => '+54 11 0000 0002',
                'whatsapp' => '+54 9 11 0000 0002',
                'email' => 'lulunta@comercio-demo.com',
                'business_hours' => 'Lunes a viernes de 10:00 a 19:00',
                'map_embed_url' => 'https://www.google.com/maps?q=Lulunta%20Mendoza&output=embed',
                'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Lulunta+Mendoza',
                'notes' => 'Segunda sucursal de ejemplo para mostrar multiples ubicaciones.',
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],
        ])->each(function (array $location) use ($profile): void {
            $profile->locations()->updateOrCreate(
                ['name' => $location['name']],
                $location,
            );
        });
    }
}
