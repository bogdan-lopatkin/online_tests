<?php


namespace App\Service;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;


class ResultService
{
    protected $model;
    protected $userModel;
    public function __construct(Answer $model,User $userModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
    }

   public function handleResult(Request $request) : array
    {
        $result = $this->model->getResult($request->get('answers'));
        $testInfo = json_decode($request->get('test_info'));
        $this->userModel->saveResult(auth()->id(),$testInfo->id ,'completed',$request->except('_token','test_info'),$result['points'],0);

        return [$result,$testInfo];
    }
}
