<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
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

        $user = User::create($validatedData);

        // var_dump( $user->id);

        $profile = Profile::createProfile($user->id);


        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response(['data' => $user, 'access_token' => $accessToken]);
    }

    // Login user
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response(['data' => Auth::user(), 'access_token' => $token]);
    }

    public function updateProfile(Request $request)
    {
        // var_dump( Auth::user()->id); exit;
        $data = $request->validate([
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'pincode' => 'string',
            'contact_no' => 'string',
        ]);

        $profile = Profile::updateProfile($data);

        return response(['data' => $profile]);
    }

    public function getUserList()
    {
        $users = User::all()->where('status', 1);

        return response(['data' => $users]);
    }

    public function blockUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 0;
            $user->save();
        }

        return response(['data' => $user]);
    }

    public function unblockUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 1;
            $user->save();
        }

        return response(['data' => $user]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 0;
            $user->deleted = 1;
            $user->save();
        }

        return response(['data' => $user]);
    }

    public function verifyUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();
        }

        return response(['data' => $user]);
    }

    public function getVerifiedUser()
    {
        $users = User::where('email_verified_at', '!=', 'null')->get();

        return response(['data' => $users]);
    }

    public function getUnverifiedUser()
    {
        $users = User::where('email_verified_at', null)->get();

        return response(['data' => $users]);
    }

    public function logout(Request $request)
    {
        // Get user who requested the logout
        $user = request()->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response([
            'message' => 'Logout Success'
        ]);
    }

}
