<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\ThreadAnswer;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $type = $request['type'] == 'answer' ? "App\Models\ThreadAnswer" : "App\Models\Thread";
        if(is_null(Like::where(
            ['likeable_id' => $request['postId'],
            'user_id' => $request['id']])->first()
        )) {
            $like = new Like();
            $like->likeable_id = $request['postId'];
            $like->likeable_type = $type;
            $like->user_id = $request['id'];
            $like->save();
            return json_encode(['likes' => ThreadAnswer::find($like->likeable_id)->likes->count(), 'action' => 'like']);
        } else {
           Like::where(
                ['likeable_id' => $request['postId'],
                'user_id' => $request['id'],
                'likeable_type' => $type]
                )->delete();
            return json_encode(['likes' => ThreadAnswer::find($request['postId'])->likes->count(), 'action' => 'dislike']);
        }
    }

}
