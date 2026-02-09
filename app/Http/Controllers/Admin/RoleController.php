<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create(['name' => $validated['name']]);
        
        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dibuat!');
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Prevent renaming system roles
        $systemRoles = ['super-admin', 'admin', 'editor', 'author'];
        
        if (in_array($role->name, $systemRoles) && $request->name !== $role->name) {
            return back()->with('error', 'Nama system role tidak dapat diubah!');
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => $validated['name']]);
        
        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diupdate!');
    }

    public function destroy(Role $role)
    {
        // Prevent deleting system roles
        $systemRoles = ['super-admin', 'admin', 'editor', 'author'];
        
        if (in_array($role->name, $systemRoles)) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'System role tidak dapat dihapus!'
                ], 403);
            }
            
            return back()->with('error', 'System role tidak dapat dihapus!');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role tidak dapat dihapus karena masih memiliki ' . $role->users()->count() . ' user!'
                ], 403);
            }
            
            return back()->with('error', 'Role tidak dapat dihapus karena masih memiliki ' . $role->users()->count() . ' user!');
        }

        $role->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus!');
    }
}
