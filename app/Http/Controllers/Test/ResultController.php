<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Service\ResultService;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    protected $model;
    protected $userModel;
    protected $service;
    public function __construct(ResultService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $data = $this->service->handleResult($request);
        //return view('Tests.result',
         return json_encode(['result' => $data[0],'test' => $data[1]]);
    }
}
