<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Block execution in production to prevent accidental data loss
        if (app()->environment('production')) {
            $this->command->error('❌ AdminUserSeeder cannot run in production environment.');
            $this->command->warn('   To create an admin manually, use: php artisan tinker');
            return;
        }

        // Use firstOrCreate to avoid deleting existing users
        $exists = User::where('email', 'admin@example.com')->exists();

        if ($exists) {
            $this->command->warn('⚠️  Admin account already exists, skipping creation.');
            $this->command->info('   Email: admin@example.com');
            return;
        }

        // Generate a strong random password
        $password = Str::password(16, letters: true, numbers: true, symbols: false);

        $admin = User::create([
            'name'               => 'Administrator',
            'email'              => 'admin@example.com',
            'password'           => Hash::make($password),
            'is_active'          => true,
            'bio'                => 'System Administrator - Full Access',
            'email_verified_at'  => now(),
        ]);

        $admin->assignRole('super-admin');

        $this->command->info('✅ Admin account created successfully!');
        $this->command->info('📧 Email   : admin@example.com');
        $this->command->info('🔑 Password: ' . $password);
        $this->command->warn('⚠️  Save this password now — it will NOT be shown again.');
    }
}
