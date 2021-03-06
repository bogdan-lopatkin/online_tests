<?php

namespace App\Models;

use Carbon\Carbon;
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
        'name', 'email', 'password','role_id','banned','time_passed','email_verified_at'
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
      return $this->belongsToMany(Role::class,'user_role');
    }

    public function tests()
    {
       return $this->belongsToMany(Test::class,'user_test')->withPivot('status','mark','picked_answers','time_passed','created_at');
    }

    public function saveResult($id,$testId,$status,$answers = null,$mark,$time)
    {
        if(!$this->with('user_id',$id,'test_id',$testId)) {
            $this->find($id)->tests()->attach(array($testId => ['status' => $status,
                'mark' => $mark ?? 0,
                'picked_answers' => json_encode($answers),
                'time_passed' => $time
            ]));
        } else {
            $this->find($id)->tests()->sync(array($testId => ['status' => $status,
                'mark' => $mark  ?? 0,
                'picked_answers' => json_encode($answers),
                'time_passed' => $time
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

    public function checkRole($role_id)
    {
        return $this->find(auth()->id())->roles->contains($role_id);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function updateRoles($roles,$id)
    {
        $this->find($id)->roles()->detach();
        foreach ($roles as $role) {
                $this->find($id)->roles()->attach($role);
            }
    }

    public function threads()
    {
        return $this->hasMany(Thread::class,'owner_id');
    }

    public function humanDate($date)
    {
        Carbon::setLocale('ru');
        return  $date ?  $date->diffForHumans() : 'Н/Д';
    }
}
