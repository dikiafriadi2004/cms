<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions (With .own for ownership control)
        $permissions = [
            // Dashboard
            'dashboard.view',
            
            // Posts Management
            'posts.view',
            'posts.create',
            'posts.edit',        // Edit ALL posts (admin, editor)
            'posts.edit.own',    // Edit OWN posts only (author)
            'posts.delete',      // Delete ALL posts (admin, editor)
            'posts.delete.own',  // Delete OWN posts only (author)
            'posts.publish',
            
            // Pages Management
            'pages.view',
            'pages.create',
            'pages.edit',        // Edit ALL pages (admin, editor)
            'pages.edit.own',    // Edit OWN pages only (author)
            'pages.delete',      // Delete ALL pages (admin, editor)
            'pages.delete.own',  // Delete OWN pages only (author)
            'pages.publish',
            
            // Categories Management
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',
            
            // Tags Management
            'tags.view',
            'tags.create',
            'tags.edit',
            'tags.delete',
            
            // Media Management
            'media.view',
            'media.upload',
            'media.edit',
            'media.delete',
            
            // Menu Management
            'menus.view',
            'menus.create',
            'menus.edit',
            'menus.delete',
            'menus.items.manage',
            
            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.toggle.status',
            
            // Role & Permission Management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.edit',
            
            // Settings Management
            'settings.view',
            'settings.edit',
            
            // Ads Management
            'ads.view',
            'ads.create',
            'ads.edit',
            'ads.delete',
            
            // Contact Management
            'contacts.view',
            'contacts.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $authorRole = Role::firstOrCreate(['name' => 'author']);

        // Super Admin - All permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin - All permissions except role/permission management
        $adminPermissions = [
            'dashboard.view',
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.publish',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete', 'pages.publish',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'tags.view', 'tags.create', 'tags.edit', 'tags.delete',
            'media.view', 'media.upload', 'media.edit', 'media.delete',
            'menus.view', 'menus.create', 'menus.edit', 'menus.delete', 'menus.items.manage',
            'users.view', 'users.create', 'users.edit', 'users.toggle.status',
            'settings.view', 'settings.edit',
            'ads.view', 'ads.create', 'ads.edit', 'ads.delete',
            'contacts.view', 'contacts.delete',
        ];
        $adminRole->syncPermissions($adminPermissions);

        // Editor - Can edit ALL content (review & revise)
        $editorPermissions = [
            'dashboard.view',
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.publish',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete', 'pages.publish',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'tags.view', 'tags.create', 'tags.edit', 'tags.delete',
            'media.view', 'media.upload', 'media.edit', 'media.delete',
            'menus.view', 'menus.create', 'menus.edit', 'menus.items.manage',
            'ads.view', 'ads.create', 'ads.edit', 'ads.delete',
            'contacts.view',
        ];
        $editorRole->syncPermissions($editorPermissions);

        // Author - Can only edit OWN content
        $authorPermissions = [
            'dashboard.view',
            'posts.view', 'posts.create', 'posts.edit.own', 'posts.delete.own',
            'pages.view', 'pages.create', 'pages.edit.own', 'pages.delete.own',
            'categories.view',
            'tags.view', 'tags.create',
            'media.view', 'media.upload', 'media.edit',
            'contacts.view',
        ];
        $authorRole->syncPermissions($authorPermissions);

        $this->command->info('✅ Permissions created: ' . count($permissions));
        $this->command->info('✅ Roles created: 4 (super-admin, admin, editor, author)');
        $this->command->newLine();
        $this->command->info('📋 Role Hierarchy:');
        $this->command->info('   • Super Admin: Full access (all permissions)');
        $this->command->info('   • Admin: Full content access (cannot manage roles)');
        $this->command->info('   • Editor: Can edit ALL posts/pages (review & revise)');
        $this->command->info('   • Author: Can only edit OWN posts/pages');
    }
}
