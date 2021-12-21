<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'address', 'city', 'state', 'pincode', 'contact_no'
    ];

    public static function createProfile($user_id) {
        $data = [
            'user_id' => $user_id
        ];

        $profile = Profile::create($data);

        return $profile;
    }

    public static function updateProfile($data) {

        $user = Profile::where( 'user_id', Auth::user()->id)->first();

        $user->address = $data['address'];
        $user->city = $data['city'];
        $user->state = $data['state'];
        $user->pincode = $data['pincode'];
        $user->contact_no = $data['contact_no'];

        if ($user->save()){
            return Profile::where( 'user_id', Auth::user()->id)->first();
        }
    }
}
