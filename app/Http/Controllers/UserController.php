<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserIndexResource;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;

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

        $token = $user->createToken('accessToken')->plainTextToken;

        $response = [
            'user' => $user,
            'accessToken' => $token,
            'id' => $user->id

        ];

        return response($response, 201);
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
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        //Check Email
        $user = User::where('email', $formFields['email'])->first();

        //Check Password

        if (!$user || !Hash::check($formFields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('accessToken')->plainTextToken;


        $userMod = $user;
        $userMod['exists']=true;

        $response = [
            'status' => 'success',
            'user' => $userMod,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
        return response()->json(['status' => 'success', 'message' => 'Logged Out'], 200);
    }

    public function unauthenticated()
    {
        return response()->json(['message' => 'Unauthenticated', 'tokenAuthenticated' => false], 401);
    }


   /*  public function checkToken()
    {
        return response()->json(['status' => 'success', 'message' => 'Token authenticated', 'tokenAuthenticated' => true]);
    } */
}
