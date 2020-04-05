<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Test extends Model
{
    protected $fillable = ['name','description','category_id','difficulty','max_time','questions','max_points'];


   public function questions() // questions with answers related to chosen test
   {
       return $this->hasMany(Question::class)->inRandomOrder();
   }

    public function testCategories() // full info about every available category
    {
        return $this->with('category')
            ->select('category_id',
                DB::raw('min(difficulty) as minDifficulty'),
                DB::raw('max(difficulty) as maxDifficulty'),
                DB::raw('count(id) as total'))
            ->groupBy('category_id')
            ->get();
    }
    public function category()  // info about chosen tests category
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function categoryTests($id,$testName = null)  // list of tests in chosen category
    {
        if(is_null($testName)) {
            return $this->with('category')
                ->where('category_id', $id)
                ->get();
        } else {
            return $this->with('category')
                ->where('name','like','%' . $testName . '%')
                ->get()
                ->sortBy('category_id');
        }
    }

    public function getTestData($id)  // get questions with answers + category
    {
        return $this->with(['questions.answers','category'])->where('id',$id)->get();
    }

    public function users()   // pivot table
    {
        $this->belongsToMany(User::class,'user_test');
    }



// Admin Section

    public function getAdminTestData($data)
    {
        return $this->with(['questionsCount','category'])
            ->where('id',($id ?? '!='),($id ?? 'null'))
            ->orderBy($data['orderBy'] ?? 'id',$data['param'] ?? 'asc')
            ->paginate(15);
    }


    public function questionsCount()
    {
        return $this->hasMany(Question::class)
            ->select('id','test_id',DB::raw('count(test_id) as total'))
            ->groupBy('test_id');

    }

    public function saveTest($data)
    {
       return $this->create([
            'name' => $data['testName'],
            'description' => $data['testDescription'],
            'category_id'=> $data['testCategory'],
            'difficulty' => $data['testDifficulty'],
            'max_time' => $data['maxTime'],
            'questions' => $data['questionsCount'],
            'max_points' => $data['max_points']
        ]);
    }

    public function getTestInfo($id)
    {
       return $this->with('getQuestionsInfo')->where('id',$id)->first();
    }

    public function updateTest($id,$data)
    {
        $this->find($id)->update([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'max_time' => $data['max_time'],
            'difficulty' => $data['difficulty'],
        ]);
    }

    public function getQuestionsInfo()
    {
        return $this->hasMany(Question::class)->with(['answersCount']);
    }
}
