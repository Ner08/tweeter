<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\UserIndexResource;
use Illuminate\Contracts\Session\Session;

class UserController extends Controller
{
    public function index()
    {
        return UserIndexResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserIndexResource($user);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'userName' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => 'required|confirmed|min:6'
        ]);

        $formFields['email_verified_at'] = Carbon::now();
        $formFields['password'] = bcrypt($request->password);

        $user = User::create($formFields);

        auth()->login($user);

        return response()->json(['status' => 'success'], 200);

    }
    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name' => 'min:3',
            'userName' => 'unique:users',
            'email' => ['unique:users', 'email'],
            'password' => 'confirmed|min:6'
        ]);

        if ($request->has('password')) {
            $formFields['password'] = bcrypt($request->password);
        }

        $user->update($formFields);

        return response()->json(['status' => 'success'], 200);

    }

    public function destroy(User $user)
    {
        auth()->logout();
        $user->delete();

        return response()->json(["status" => "success"], 200);
    }

    public function login(Request $request)
    {
        $formFields = $request->validate([
            "email" => ["required,email"],
            "password" => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return response()->json(['status' => 'success'], 200);
        }
        return response()->json(['status' => 'unsuccessful'], 404);
    }

    public function logout(Session $session)
    {
        auth()->logout();
        $session->invalidate();
        $session->regenerateToken();
        return json_encode(["status" => "success"], 200);
    }
}
