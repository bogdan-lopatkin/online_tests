<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\EditUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('user_profile',['user' => User::with(['tests','threads'])->find($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUser $request, $id)
    {
       $user = User::find($id);
       $user->name = $request['name'];
       $user->password = $request['password'] ? bcrypt($request['password']) : $user->password;
       if($request['email']) {
           $user->email = $request['email'];
           $user->email_verified_at = null;
       }
        $user->save();
       return redirect(URL::previous());
    }


}
