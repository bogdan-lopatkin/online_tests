<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserEdit;
use App\Http\Requests\Admin\UserStore;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = [];
        foreach (Role::select('*')->get() as $item)  $roles[$item->id] = $item->name;
        return view('Admin.users',['users' => $this->model->with('roles')->get(), 'roles' => $roles ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('Admin.users.add')->with('roles' , Role::select('*')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        $user = $this->model->create(['name' => $request['name'],'email' => $request['email'],
            'banned' => $request['banned'],
            'password' => bcrypt($request['password']),
        ]);
        $request['confirm_email'] ? $user->email_verified_at = Carbon::yesterday() : $user->email_verified_at = null;
        $user->save();
        $user->updateRoles($request['role'],$user->id);
        return redirect(URL::previous());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('Admin.users.edit',['user' => $this->model->with('roles')->find($id), 'roles' => Role::select('*')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEdit $request, $id)
    {
       $user = $this->model->find($id);
       $user->update(['name' => $request['name'],'email' => $request['email'],
           'banned' => $request['banned'],
           'password' => $request['password'] ? bcrypt($request['password']) : $user->password
       ]);
       $user->updateRoles($request['role'],$id);
        return redirect(URL::previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect(URL::previous());
    }
}
