<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuccessStory;

class SuccessStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success_story = SuccessStory::all();
        // var_dump($success_story); exit;
        return response(['data' => $success_story]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'name' => $request->name,
            'title' => $request->title,
            'story' => $request->story
        ];

        $success_story = SuccessStory::create($data);
        return response(['data' => $success_story]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $success_story = SuccessStory::find($id);
        return response(['data' => $success_story]);
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
        $success_story = SuccessStory::find($id);

        if ($success_story) {
            $success_story->user_id = $request->user_id;
            $success_story->name = $request->name;
            $success_story->title = $request->title;
            $success_story->story = $request->story;
            $success_story->save();
        }
        
        return response(['data' => $success_story]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success_story = SuccessStory::find($id);

        return response([
            'data' => $success_story->delete()
        ]);
    }
}
