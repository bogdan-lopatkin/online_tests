<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

class Question extends Model
{
    protected $fillable = ['question_body','test_id','points'];
    public $timestamps = false;
    public function answers()
    {
        return $this->hasMany(Answer::class)->select('id','question_id','answer_body');
    }
}
