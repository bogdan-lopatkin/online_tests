<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\User;
use App\Providers\TestServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TestController1 extends Controller
{
    protected $service;
    protected $model;
    protected $userModel;

    public function __construct(Test $model,User $user)
    {
        $this->model = $model;
        $this->userModel = $user;
    }


    public function index()
    {
        return view('tests/categories',['testCategories' => $this->model->testCategories(),
            'difficulty'=>['offset','Начинающий','Ученик','Студент','Знаток','Профессионал']]);
    }

    public function showCategory(Request $request, $id)
    {
        return view('tests/categoryTests',['tests' => $this->model->categoryTests($id,$request->get('s')),'request' => $request->get('s')]);
    }

    public function startTest($id)
    {
        return view('tests/test',['testData' => $this->model->getTestData($id), 'savedData' => $this->userModel->getSavedTestData(Auth::id(),$id) ]);
    }
}
