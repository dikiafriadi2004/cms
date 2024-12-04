<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            }
        })->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('backend.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:password_confirmation|required_with:password_confirmation',
            'password_confirmation' => 'required_with:password'
        ], [
            'name.required' => 'Name a field is required',
            'email.required' => 'Email a field is required',
            'email.email' => $request->email . 'Email format is not correct',
            'email.unique' => 'Email already exists in the database, please use another email',
            'password.required_with' => 'Password a field is required',
            'password_confirmation.required_with' => 'Confirmation Password a field is required'
        ]);

        $email_verified_at = $request->email_verified_at ? Carbon::now() : null;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $email_verified_at,
            'password' => bcrypt($request->new_password)
        ];

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $permissions = Permission::get();
        return view('backend.admin.users.edit', compact('user', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => 'nullable|min:6|same:new_password_confirmation|required_with:new_password_confirmation',
            'new_password_confirmation' => 'required_with:new_password'
        ], [
            'name.required' => 'Name a field is required',
            'email.required' => 'Email a field is required',
            'email.email' => $request->email . 'Email format is not correct',
            'email.unique' => 'Email already exists in the database, please use another email',
            'new_password.required_with' => 'Password a field is required',
            'new_password_confirmation.required_with' => 'Confirmation Password a field is required'
        ]);

        $email_verified_at = $user->email_verified_at ? $user->email_verified_at : Carbon::now();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $email_verified_at,
            'password' => $request->new_password ? bcrypt($request->new_password) : $user->password
        ];

        User::where('id', $user->id)->update($data);

        $user->syncPermissions($request->permissions);


        return redirect()->route('users.index')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $posts = Post::where('user_id', $user->id)->get();

        foreach ($posts as $post) {
            if (file_exists(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION') . "/" . $post->thumbnail)) && isset($post->thumbnail)) {
                unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION') . "/" . $post->thumbnail));
            }
        }

        User::where('id', $user->id)->delete();
        return redirect()->back()->with('success', 'Data user has been deleted');
    }

    public function toggleBlock(User $user)
    {
        $message = '';

        if ($user->blocked_at == null) {
            $data = [
                'blocked_at' => now()
            ];

            $message = "User " . $user->name . " has been blocked";
        } else {
            $data = [
                'blocked_at' => null
            ];

            $message = "User " . $user->name . " has been unblock";
        }

        User::where('id', $user->id)->update($data);

        return redirect()->back()->with('success', $message);
    }
}
