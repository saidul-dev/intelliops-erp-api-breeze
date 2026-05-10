<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::with('roles')
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->get('status'));
            })
            ->orderBy('id', 'desc')
            ->paginate($request->get('per_page', 10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'status' => 'required|string|in:active,inactive',
            'roles' => 'array|required',
            'roles.*' => 'exists:roles,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['password'] = bcrypt($data['password']);

        if ($request->has('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user = User::create($data);

        $user->roles()->sync($data['roles']);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
            'status' => 'string|in:active,inactive',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($request->has('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        $user->load('roles');

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach();

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
