<?php

namespace App\Http\Controllers;

use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List 
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) { // use filled() instead of has() to check not empty
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('role', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $users = $query->paginate(10)->appends($request->all()); // preserve search in pagination
        return view('users.index', compact('users'));
    }

    // Store 
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:Admin,Encoder',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->role     = $request->role;
        $user->password = bcrypt($request->password);
        $user->status   = 'Active'; 
        $user->save(); 
        
        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return array(
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'email|unique:users,email,' . $id
        ]);
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email; 
        $user->role = $request->role;
        $user->save();

        Alert::success('Successfully Update')->persistent('Dismiss');
        return back();
    }

    public function userChangePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'confirmed|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        Alert::success('Successfully Change Password')->persistent('Dismiss');
        return back();
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Inactive';
        $user->save();

        Alert::success('Successfully Deactivated')->persistent('Dismiss');
        return back();
    }
}
