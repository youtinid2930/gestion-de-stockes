<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    
    // Display a listing of the resource.
    public function index()
    {
        $users = User::all();
        return view('utilisateur.index', compact('users'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $roles = Role::all();
        return view('utilisateur.create', [
            'roles' => $roles,
            'utilisateur' => new User() 
        ]);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'etat' => 'required|string|in:actif,inactif',
            'role' => 'required|exists:roles,name', // Validate the role name
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'etat' => $request->etat,
            'password' => Hash::make('defaultpassword'), // you might want to handle password more securely
        ]);

        $user->assignRole($request->role); // Assign the role by name

        return redirect()->route('utilisateur.index')->with('success', 'User created successfully.');
    }
    // Show all informations of one user

    public function show($id) {
        $utilisateur = User::with('roles')->find($id);
        return view('utilisateur.show', compact('utilisateur'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $utilisateur = User::findOrFail($id);
        $roles = Role::all();
        return view('utilisateur.edit', compact('utilisateur', 'roles'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $utilisateur = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($id ?? 'NULL'),
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'etat' => 'required|string|in:actif,inactif',
            'role' => 'required|exists:roles,name', // Validate the role name
        ]);

        $utilisateur->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'etat' => $request->etat,
        ]);

        $utilisateur->syncRoles($request->role); // Sync the roles by name

        return redirect()->route('utilisateur.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $utilisateur = User::findOrFail($id);
        $utilisateur->delete();
        return redirect()->route('utilisateur.index')->with('success', 'User deleted successfully.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%$query%")
                    ->orWhere('last_name', 'LIKE', "%$query%")
                    ->orWhere('email', 'LIKE', "%$query%")
                    ->get();

        return view('utilisateur.index', compact('users'));
    }

}
