<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RefreshPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh permissions and sync with roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing permissions...');

        // All permissions (With .own for ownership control)
        $permissions = [
            // Dashboard
            'dashboard.view',
            
            // Posts Management
            'posts.view', 'posts.create', 'posts.edit', 'posts.edit.own', 'posts.delete', 'posts.delete.own', 'posts.publish',
            
            // Pages Management
            'pages.view', 'pages.create', 'pages.edit', 'pages.edit.own', 'pages.delete', 'pages.delete.own', 'pages.publish',
            
            // Categories Management
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            
            // Tags Management
            'tags.view', 'tags.create', 'tags.edit', 'tags.delete',
            
            // Media Management
            'media.view', 'media.upload', 'media.edit', 'media.delete',
            
            // Menu Management
            'menus.view', 'menus.create', 'menus.edit', 'menus.delete', 'menus.items.manage',
            
            // User Management
            'users.view', 'users.create', 'users.edit', 'users.delete', 'users.toggle.status',
            
            // Role & Permission Management
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete', 'permissions.view', 'permissions.edit',
            
            // Settings Management
            'settings.view', 'settings.edit',
            
            // Ads Management
            'ads.view', 'ads.create', 'ads.edit', 'ads.delete',
            
            // Contact Management
            'contacts.view', 'contacts.delete',
        ];

        $created = 0;
        $existing = 0;

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            if ($perm->wasRecentlyCreated) {
                $created++;
            } else {
                $existing++;
            }
        }

        $this->info("Created: {$created} new permissions");
        $this->info("Existing: {$existing} permissions");

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->info('Permission cache cleared!');

        $this->newLine();
        $this->info('✅ Permissions refreshed successfully!');
        $this->info('Total permissions: ' . count($permissions) . ' (With .own for multi-user)');

        return Command::SUCCESS;
    }
}
