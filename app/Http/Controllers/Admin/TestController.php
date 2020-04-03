<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected $model;
    protected $categoryModel;

    public function __construct(Test $model,Category $category)
    {
        $this->model = $model;
        $this->categoryModel = $category;
    }

    public function index(Request $request)
    {
        return view('Admin.tests',['tests' => $this->model->getAdminTestData($request->input())]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.tests.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->json()->all();
        $id = $this->model->saveTest($data)->id;
        foreach ($data['questions'] as $question) {
            $questionId = Question::create([
                'question_body' => $question['name'],
                'test_id' => $id,
                'points' => $question['points']
            ])->id;
            foreach ($question['answers'] as $answer) {
                Answer::create([
                    'answer_body' => $answer['name'],
                    'question_id' => $questionId,
                    'is_correct' => $answer['correct']
               ]);
            }
        }
        return URL::previous();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('Admin.tests.show',['test' => $this->model->getTestInfo($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('Admin.tests.edit',['test' => $this->model->find($id),
            'categories' => $this->categoryModel->getCategories()]);
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
        $this->model->updateTest($id,$request->all());
        return redirect(URL::previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect(URL::previous());
    }
}
