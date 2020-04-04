<?php


namespace App\Service;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;


class SaveTestService
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

   public function handleTestSave(Request $request) : void
    {
        $currentTest['answers'] = $request->json('answers');
        $currentTest['time'] = $request->json('time');
        $currentTest['testId'] = $request->json('testId');
        $this->model->saveResult(auth()->id(),$currentTest['testId'],'started',$request->json('answers'),null,$currentTest['time']);
        session()->forget('currentTest');
        session()->push('currentTest',$currentTest);
    }
}
