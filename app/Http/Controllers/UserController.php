<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\EditUser;
use App\Models\User;
use Illuminate\Http\Request;

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
        //
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
       $user->password = bcrypt($request['new_password']) ?? $user->password;
       if($request['email']) {
           $user->email = $request['email'];
           $user->email_verified_at = null;
       }
        $user->save();
    }


}
