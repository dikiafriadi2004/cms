<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all existing users first
        User::query()->delete();

        // Create single admin account with full access
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@konterdigital.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'bio' => 'System Administrator - Full Access',
            'email_verified_at' => now(),
        ]);

        // Assign super-admin role (full access to all features)
        $admin->assignRole('super-admin');

        $this->command->info('✅ Admin account created successfully!');
        $this->command->info('📧 Email: admin@konterdigital.com');
        $this->command->info('🔑 Password: password');
        $this->command->warn('⚠️  Please change the password after first login!');
    }
}
