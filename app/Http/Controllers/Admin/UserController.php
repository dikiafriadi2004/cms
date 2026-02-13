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

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->syncRoles($request->roles);

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
            'email' => 'required|email|unique:users,email,' . $user->id,
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

        // Prevent users from modifying their own roles and status
        if ($user->id === auth()->id()) {
            unset($validated['roles']);
            unset($validated['is_active']);
        }

        $user->update($validated);
        
        // Only sync roles if not editing own account
        if ($user->id !== auth()->id()) {
            $user->syncRoles($request->roles);
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
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Status user berhasil diupdate!'
        ]);
    }
}