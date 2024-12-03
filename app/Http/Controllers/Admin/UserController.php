<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('backend.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Name a field is required',
            'email.required' => 'Email a field is required',
            'email.email' => $request->email . 'Email format is not correct',
            'email.unique' => 'Email already exists in the database, please use another email'
        ]);

        $email_verified_at = $user->email_verified_at ? $user->email_verified_at : Carbon::now();

        User::where('id', $user->id)->update();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $email_verified_at
        ];

        User::where('id', $user->id)->update($data);

        return redirect()->route('users.index')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
