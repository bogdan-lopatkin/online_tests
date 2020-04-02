<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    protected $model;
    protected $userModel;
    public function __construct(Answer $model,User $userModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request)
    {
        $result = $this->model->getResult($request->except('_token','test_info'));
        $testInfo = json_decode($request->get('test_info'));
        $this->userModel->saveResult(auth()->id(),$testInfo->id ,'completed',$request->except('_token','test_info'),$result['points']);
        return view('Tests.result', ['result' => $result,'test' => $testInfo]);
    }
}
