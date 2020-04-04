<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\SaveTestService;
use Illuminate\Http\Request;

class SaveTestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $service;
    public function __construct(SaveTestService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
       $this->service->handleTestSave($request);
        return  session()->get('currentTest');
    }
}
