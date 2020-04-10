<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['owner_id','name','description'];

    public function threads()
    {
        return $this->with('owner','likes')->orderBy('created_at','desc')->get();
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function answers()
    {
        return $this->hasMany(ThreadAnswer::class);
    }

    public function threadInfo($id)
    {
         return $this->with('owner','likes','answers')->where('id',$id)->first();
    }

    public function humanDate($date)
    {
        Carbon::setLocale('ru');
        return $date->diffForHumans();
    }
}
