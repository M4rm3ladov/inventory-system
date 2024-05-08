<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system-user.user');
    }

    public function register()
    {
        $branches = Branch::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('system-user.register', ['branches' => $branches, 'roles' => $roles]);
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->withErrors(['email' => 'Username or password incorrect']);
    }

    public function login()
    {
        return view('system-user.login');
    }

    public function logout() 
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerate();

        return redirect()->route('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('register')->with('success', 'Account created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $branches = Branch::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('system-user.user-edit', compact('user', 'branches', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        
        $user->update($validated);

        return redirect()->route('users.edit', $user->id)->with('success', 'Account updated successfully!');
    }

    public function editCredential(User $user) {
        return view('system-user.credential-edit', compact('user'));
    }

    public function updateCredential(User $user) {
        $validated = request()->validate([
            'password' => 'required|confirmed|min:6', 
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user->update($validated);

        return redirect()->route('users.edit', $user->id)->with('success', 'Password changed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
