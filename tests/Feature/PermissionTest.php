<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test role can be created
     */
    public function test_role_can_be_created(): void
    {
        $role = Role::create(['name' => 'editor']);

        $this->assertDatabaseHas('roles', [
            'name' => 'editor',
        ]);
    }

    /**
     * Test permission can be created
     */
    public function test_permission_can_be_created(): void
    {
        $permission = Permission::create(['name' => 'edit posts']);

        $this->assertDatabaseHas('permissions', [
            'name' => 'edit posts',
        ]);
    }

    /**
     * Test user can be assigned role
     */
    public function test_user_can_be_assigned_role(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole('editor'));
    }

    /**
     * Test role can be assigned permissions
     */
    public function test_role_can_be_assigned_permissions(): void
    {
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit posts']);

        $role->givePermissionTo($permission);

        $this->assertTrue($role->hasPermissionTo('edit posts'));
    }

    /**
     * Test user has permission through role
     */
    public function test_user_has_permission_through_role(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit posts']);

        $role->givePermissionTo($permission);
        $user->assignRole($role);

        $this->assertTrue($user->hasPermissionTo('edit posts'));
    }

    /**
     * Test user without permission cannot access protected route
     */
    public function test_user_without_permission_cannot_access_protected_route(): void
    {
        $user = User::factory()->create();
        Permission::create(['name' => 'posts.create']);

        $response = $this->actingAs($user)->get('/admin/posts/create');

        $response->assertStatus(403);
    }

    /**
     * Test user with permission can access protected route
     */
    public function test_user_with_permission_can_access_protected_route(): void
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'posts.create']);
        
        $user->givePermissionTo($permission);

        $response = $this->actingAs($user)->get('/admin/posts/create');

        $response->assertStatus(200);
    }

    /**
     * Test admin role has all permissions
     */
    public function test_admin_role_has_all_permissions(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $permission1 = Permission::create(['name' => 'posts.create']);
        $permission2 = Permission::create(['name' => 'posts.edit']);
        $permission3 = Permission::create(['name' => 'posts.delete']);

        $admin->givePermissionTo([$permission1, $permission2, $permission3]);

        $this->assertTrue($admin->hasPermissionTo('posts.create'));
        $this->assertTrue($admin->hasPermissionTo('posts.edit'));
        $this->assertTrue($admin->hasPermissionTo('posts.delete'));
    }

    /**
     * Test user can have direct permissions
     */
    public function test_user_can_have_direct_permissions(): void
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'special.action']);

        $user->givePermissionTo($permission);

        $this->assertTrue($user->hasPermissionTo('special.action'));
    }

    /**
     * Test permission can be revoked from user
     */
    public function test_permission_can_be_revoked_from_user(): void
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'edit posts']);

        $user->givePermissionTo($permission);
        $this->assertTrue($user->hasPermissionTo('edit posts'));

        $user->revokePermissionTo($permission);
        $this->assertFalse($user->hasPermissionTo('edit posts'));
    }
}

