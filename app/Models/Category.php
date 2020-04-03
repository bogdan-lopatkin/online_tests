<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function countTests()
    {
        return $this->hasMany(Test::class)
            ->select('id','category_id',DB::raw('count(category_id) as total'))
            ->groupBy('category_id');

    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }


    public function categoriesInfo()
    {
        return $this->with('countTests')->get();
    }

    public function getCategoryTests($id)
    {
       return $this->find($id);
    }

    public function getCategories()
    {
        $res = [];
        foreach ($this->select('id','name')->get() as $category)
            $res[$category->id] = $category->name;
        return $res;
    }

}

