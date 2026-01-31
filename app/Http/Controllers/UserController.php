<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{

    // List all users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show create user form
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            'role'=>'required|in:user,supervisor,storekeeper,admin'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        return redirect()->route('users.index')->with('success','User created');
    }

    // Show edit user form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:user,supervisor,storekeeper,authoriser,admin',
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
        ]);

        return redirect()->route('users.index')->with('success','User updated');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','User deleted');
    }

    // Show reset password form
    public function resetPasswordForm(User $user)
    {
        return view('admin.users.reset-password', compact('user'));
    }

    // Reset password
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user->update([
            'password'=>Hash::make($request->password)
        ]);

        return redirect()->route('users.index')->with('success','Password reset successfully');
    }
}
