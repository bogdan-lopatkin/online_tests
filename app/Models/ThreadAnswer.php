<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ThreadAnswer extends Model
{
    protected $fillable = ['thread_id','owner_id','description'];

    public function humanDate($date)
    {
        Carbon::setLocale('ru');
        return $date->diffForHumans();
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

}
