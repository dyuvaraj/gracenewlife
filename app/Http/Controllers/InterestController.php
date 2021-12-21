<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendInterest($to_user_id)
    {
        $users = User::find($to_user_id);
        
        if ($users) {
            $interests = Interest::where('from_user_id', Auth::user()->id)->where('to_user_id', $to_user_id)->first();
            if (!$interests) {
                $data = [
                    'from_user_id' => Auth::user()->id,
                    'to_user_id' => $to_user_id,
                    'seen' => 0
                ];
                $sendInterest = Interest::create($data);

                return response(['data' => $sendInterest]);
            }
        }
    }

    public function viewInterest()
    {
        $interests = Interest::where('to_user_id', Auth::user()->id)->get();

        return response(['data' => $interests]);
    }

    public function getsentInterest()
    {
        $interests = Interest::where('from_user_id', Auth::user()->id)->get();

        return response(['data' => $interests]);
    }
}