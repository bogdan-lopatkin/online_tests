<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    public function tests()
    {
       return $this->belongsToMany(Test::class,'user_test')->withPivot('status','mark','picked_answers','created_at');
    }

    public function saveResult($id,$testId,$status,$answers = null,$mark = null)
    {
        if(!$this->with('user_id',$id,'test_id',$testId)) {
            $this->find($id)->tests()->attach(array($testId => ['status' => $status,
                'mark' => $mark,
                'picked_answers' => json_encode($answers)
            ]));
        } else {
            $this->find($id)->tests()->sync(array($testId => ['status' => $status,
                'mark' => $mark,
                'picked_answers' => json_encode($answers)
            ]),false);
        }
    }

    public function getUserTests($id)
    {
        return $this->find($id)->tests()->get();
    }

    public function getSavedTestData($userId,$testId)
    {
       return $this->find($userId)->tests()->where('test_id',$testId)->get();

    }
}
