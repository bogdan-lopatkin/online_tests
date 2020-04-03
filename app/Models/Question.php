<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mod;

class Question extends Model
{
    protected $fillable = ['question_body','test_id','points'];
    public $timestamps = false;
    public function answers()
    {
        return $this->hasMany(Answer::class)->select('id','question_id','answer_body','is_correct');
    }

    public function answersCount()
    {
        return $this->hasMany(Answer::class)
            ->select('id','question_id',DB::raw('count(id) as total'))
            ->groupBy('question_id');
    }

    public function getQuestionsInfo()
    {
        return $this->with('answersCount')->select('*')->get();
    }

    public function getQuestionWithAnswers($id)
    {
        return $this->with('answers')->where('id',$id)->first();
    }

}
