<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{   
    // Register user 
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($request->input('password'));

        $user = Admin::create($validatedData);

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    // Login user
    // public function login(Request $request)
    // {
    //     $loginData = $request->validate([
    //         'email' => 'email|required',
    //         'password' => 'required'
    //     ]);
 
    //     if (!Auth::attempt($loginData)) {
    //         return response(['message' => 'Invalid Credentials']);
    //     }

    //     $user = Auth::user()->admin ;
    //     $token = $user->createToken('authToken')->plainTextToken;

    //     return response(['user' => Auth::user(), 'access_token' => $token]);
    // }


    public function login(Request $request)
    {

        // $request->merge(['password'=> Hash::make($request->input('password'))]);

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        $user = Admin::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Please submit a valid email address and password combination.']
            ], 404);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    
    }


    // public function logout(Request $request)
    // {
    //     $cookie = Cookie::forget('jwt');

    //     return response([
    //         'message' => 'Success'
    //     ])->withCookie($cookie);
    // }

    // public function refreshToken(Request $request)
    // {
    //     $user = $request->user();
    //     $user->tokens()->delete();
    //     return response()->json(['refresh_token' => $user->createToken('token')->plainTextToken]);
    // }
    


}
