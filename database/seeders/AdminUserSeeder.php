<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@demo.local'],
            [
                'name' => 'Administrador Demo',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );
    }
}
