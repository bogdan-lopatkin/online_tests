<?php


namespace App\Service;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;


class CreateTestService
{
    protected $model;
    public function __construct(Test $model)
    {
        $this->model = $model;
    }

   public function handleTestCreate(Request $request) : void
    {
        $data =  $request->json()->all();
        $id = $this->model->saveTest($data)->id;

        $test = $this->model->find($id);
        $test->group_id = auth()->user()->group->id ?? null;
        $test->save();

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
    }
}
