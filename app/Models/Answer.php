<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    public $timestamps = false;
protected $fillable = ['answer_body','question_id','is_correct'];

    public  function answeredQuestions()
    {
        return $this->belongsTo(Question::class,'question_id','id')
            ->select('id','test_id','points');
    }

    public function totalPoints()
    {
       return $this->select(DB::raw('sum(points) as totalPoints'))->groupBy('test_id')->get();
    }

    public function getResult($answers)
    {
        $t = $this->with('answeredQuestions')->findMany($answers)->where('is_correct',1);
        $result['questions'] = $t->count();
        $result['points'] = $t->sum('answeredQuestions.points');

        return $result;
    }

}
