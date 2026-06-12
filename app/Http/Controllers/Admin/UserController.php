<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'identity_number' => 'required|string|unique:users,identity_number',
            'email'           => 'required|email|unique:users,email',
            'role'            => 'required|in:admin,technician,student,lecturer',
            'phone'           => 'nullable|string|max:30',
            'department'      => 'nullable|string|max:255',
            'password'        => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active');

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'המשתמש נוצר בהצלחה.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'identity_number' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'email'           => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'            => 'required|in:admin,technician,student,lecturer',
            'phone'           => 'nullable|string|max:30',
            'department'      => 'nullable|string|max:255',
            'password'        => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'המשתמש עודכן בהצלחה.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'לא ניתן למחוק את המשתמש שלך.');
        }

        $user->delete();

        return back()->with('success', 'המשתמש נמחק.');
    }
}
