<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','owner_id'];
    public $timestamps = false;

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function articles()
    {
       // return $this->hasMany(User::class);
    }
}
