<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Trashed filter: ?trashed=only | ?trashed=with
        if ($request->trashed === 'only') {
            $query = User::onlyTrashed()->with('roles');
        } elseif ($request->trashed === 'with') {
            $query = User::withTrashed()->with('roles');
        }

        if ($request->filled('search')) {
            $search = safe_like_input($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $perPage = in_array($request->input('per_page'), [5, 10, 20, 50]) ? (int) $request->input('per_page') : 20;
        $users = $query->latest()->paginate($perPage)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'perPage'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $isActive = (bool) ($validated['is_active'] ?? true);
        unset($validated['is_active'], $validated['roles']);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        // is_active is NOT in $fillable for security; set explicitly.
        $user->forceFill(['is_active' => $isActive])->save();
        $user->syncRoles($request->roles);

        // Invalidate permission cache so role assignment is immediate
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat!');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'posts', 'pages']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users', 'email')
                    ->ignore($user->id)
                    ->whereNull('deleted_at'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Extract is_active and roles separately — they need explicit handling.
        $isActive = $validated['is_active'] ?? null;
        unset($validated['is_active'], $validated['roles']);

        // Prevent users from modifying their own roles and status
        $editingSelf = $user->id === auth()->id();

        $user->update($validated);

        if (!$editingSelf) {
            // is_active is NOT in $fillable for security; set explicitly.
            if ($isActive !== null) {
                $user->forceFill(['is_active' => (bool) $isActive])->save();
            }
            $user->syncRoles($request->roles);

            // Invalidate permission cache
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun sendiri!'
                ], 403);
            }
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function toggleStatus(User $user)
    {
        // Prevent self-deactivation
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun sendiri!',
            ], 403);
        }

        // is_active is NOT in $fillable for security; set explicitly.
        $user->forceFill(['is_active' => !$user->is_active])->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Status user berhasil diupdate!'
        ]);
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index', ['trashed' => 'only'])
            ->with('success', 'User berhasil direstore!');
    }

    /**
     * Permanently delete a soft-deleted user.
     */
    public function forceDestroy($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->forceDelete();

        return redirect()->route('admin.users.index', ['trashed' => 'only'])
            ->with('success', 'User berhasil dihapus permanen!');
    }
}
