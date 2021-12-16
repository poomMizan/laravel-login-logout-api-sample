<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        //
        $field = $request->validate([
            'name' => ['required','string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'password' => bcrypt($field['password']),
        ]);
        return $user->createToken('myapptoken')->plainTextToken;
        // $response = [
        //     'user' => $user,
        //     'token' => $token,
        // ];
        // return Response($response, 201);
    }
    public function login(Request $request)
    {
        //
        $check = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        
        // var_dump($check);

        // check email & password
        $user = User::where('email', $request->email)->first(); 
        if ($user == false || Hash::check($check['password'], $user->password) == false) {
            return response(['message' => 'Bad creds'], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        return response([
            'message' => 'Login success',
            'token' => $token,
        ], 401);
        // $response = [
        //     'user' => $user,
        //     'token' => $token,
        // ];
        // return response($response, 201);
    }
    public function logout()
    {
        //
        auth()->user()->tokens()->delete();
        return response(['message' => 'Token destroyed and logged out'], 200);
    }
}