<?php

namespace Database\Seeders;

use App\Models\BusinessProfile;
use Illuminate\Database\Seeder;

class BusinessProfileSeeder extends Seeder
{
    public function run(): void
    {
        BusinessProfile::query()->updateOrCreate(
            ['id' => 1],
            BusinessProfile::defaultAttributes(),
        );
    }
}
