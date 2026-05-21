<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();//premier user (email)

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);//Unauthorized
    }

    $token = $user->createToken('auth_token')->plainTextToken; //token claire pour frontend
    // lutilisation dans chaque requete

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
}

public function registerClient(Request $request)
{

    $user = User::create([
        'name' => $request->nom,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => 2
    ]);

    Client::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'user_id' => $user->id
    ]);

    return response()->json([
        'message' => 'Client créé'
    ]);
}
}
