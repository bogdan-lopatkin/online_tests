<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ThreadAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AnswerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        ThreadAnswer::create([
            'owner_id' => $data['owner_id'],
            'thread_id' => $data['thread_id'],
            'description' => $data['thread_answer'],
            'parent_id' => $data['parent_id'] ?? null
        ]);
        return redirect(URL::previous());
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
       $answer = ThreadAnswer::find($id);
       $answer->description = $request['edit_answer'];
       $answer->save();
       return $answer->description;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ThreadAnswer::find($id)->delete();
        return redirect(URL::previous());
    }
}
