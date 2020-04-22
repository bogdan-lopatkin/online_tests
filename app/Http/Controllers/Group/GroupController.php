<?php

namespace App\Http\Controllers\Group;


use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class GroupController extends Controller
{
    protected $model;
    public function __construct(Group $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('Group.main')->with('group',$this->model->find(auth()->user()->group_id));
    }

    public function update(Request $request)
    {
      $group = $this->model->find($request['id']);
      $group->name = $request['group_name'];
      $group->save();
      return redirect(URL::previous());
    }

}
