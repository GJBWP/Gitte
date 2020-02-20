<?php

namespace App\Http\Controllers;

use App\Exports\MdwExport;
use Illuminate\Http\Request;
use App\Project;
use App\Task;
use App\Customer;
use App\Role;
use App\User;
use App\Hour;
use App\Available;
use Carbon\Carbon;
use DB;
use Calendar;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PlannerUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customers = Customer::all();
      $projects = Project::all();
      $tasks = Task::all();
      $users = User::all();
      $countusers = User::count('id');
      $countprojects = Project::count('id');
      $counttasks = Task::count('id');
      $countcustomer = Customer::count('id');

      return view('planner.users.index', compact('customers','projects','tasks','users','countusers'));
  }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('planner.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => Hash::make($request['password']),
          'passnumber' => $request['passnumber'],
          'valid_untill' => $request['valid_untill'],
          'role_id' => $request['role_id'],
          'color' => $request['color'],
//          'beveiliger' => $request['beveiliger'],
//          'brandwacht' => $request['brandwacht'],
//          'ehbo' => $request['ehbo'],
      ]);

      return redirect('planner/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $tasks = Task::whereUserId($id)->orderBy('startdate', 'ASC')->get()->all();
      $hours = Hour::whereUserId($id)->orderBy('workedstartdate', 'ASC')->get()->all();


    return view('planner.users.show',['user'=> User::findOrFail($id)], compact('tasks','hours') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);
      return view('planner.users.edit', compact('user'));
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
      $input = $request->all();
      User::whereId($id)->first()->update($input);

      return redirect('planner/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      User::findOrFail($id)->delete();
      return redirect('planner/users');
    }

    public function exportMdw()
    {
        return Excel::download(new MdwExport, 'users.xlsx');
    }



}
