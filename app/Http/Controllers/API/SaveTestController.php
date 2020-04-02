<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SaveTestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function __invoke(Request $request)
    {
        $currentTest['answers'] = $request->json('answers');
        $currentTest['time'] = $request->json('time');
        $currentTest['testId'] = $request->json('testId');
        $this->model->saveResult(auth()->id(),$currentTest['testId'],'started',$request->json('answers'));
        session()->forget('currentTest');
        session()->push('currentTest',$currentTest);

        return  session()->get('currentTest');
    }
}
