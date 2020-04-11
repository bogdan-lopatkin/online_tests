<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class  DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     //   $dates = collect();
//
         $date = Carbon::now()->addDays( -7 )->format( 'Y-m-d' );
         $stat = UserTest::where([['created_at','>=',$date],['status','completed']])
              ->get()
              ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('d');
        });
         $data = ['1' => 0,'2' => 0,'3' => 0,'4' => 0,'5' => 0,'6' => 0,'7' => 0];
        foreach ($stat as $s)
        {
//            echo $s[0]->created_at->dayOfWeek ;
//        echo  $s;
//           echo   $s->count();
//            echo '<br>';
            $data[$s[0]->created_at->dayOfWeek] = $s->count('*');
        }
        return view('Admin.dashboard',['data' => json_encode(array_values($data))]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
