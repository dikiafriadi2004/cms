<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? (int) $request->input('per_page') : 50;
        $permissionsQuery = Permission::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $permissionsQuery->where('name', 'like', '%' . $search . '%');
        }

        $permissionsPaginated = $permissionsQuery->paginate($perPage)->withQueryString();

        // Group permissions by module for display
        $permissions = $permissionsPaginated->getCollection()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });

        // Replace collection in paginator with grouped data
        $permissionsPaginated->setCollection(collect($permissions));

        return view('admin.permissions.index', compact('permissions', 'permissionsPaginated', 'perPage'));
    }
}
