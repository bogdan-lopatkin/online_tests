<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\ThreadAnswer;
use Illuminate\Http\Request;

class LikeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $like = new Like();
        $like->likeable_id = $request['postId'];
        $like->likeable_type = $request['type'] == 'answer' ? "App\Models\ThreadAnswer" : "App\Models\Thread";
        $like->user_id = $request['id'];
        $like->save();
        return ThreadAnswer::find($like->likeable_id)->likes->count();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        Like::where(['post_type',],
//
    }
}
