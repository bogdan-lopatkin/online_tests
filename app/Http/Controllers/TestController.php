<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryName)
    {
        $tests = Category::where('name',$categoryName)->first()->categoryTests;
//        foreach ($category as $cat)
//            echo $cat->name . '<br>';
//        dd($category);
//        $tests =$category->categoryTests;
        return view('tests',['tests' => $tests,'category' => $categoryName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category,$id)
    {
        $test = Test::where('id',$id)->first();
        $questionIds = $test->questions()->get();


        $questions = Question::with('answers')->findMany($questionIds->pluck('id'));

        $currentTest =  session()->get('currentTest');
        $testInfo = null;
        if($currentTest) {
        $timeLeft = $currentTest[0]['time'];
        $answered = $currentTest[0]['answers'];
        $testId = $currentTest[0]['testId'];
        $testInfo = ['time' => $timeLeft,'answered'=>$answered,'testId' => $testId];

        }
        return view('test',compact('questions','test','testInfo'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
