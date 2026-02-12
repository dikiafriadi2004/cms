<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            MenuSeeder::class,
            AdSeeder::class,
            // ImageAdSeeder::class, // Uncomment jika ingin seed image ads (perlu upload gambar dulu)
        ]);
    }
}
