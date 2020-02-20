<?php

namespace App\Http\Controllers;

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


class PlannerController extends Controller
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
      $countusers = User::whereDeletedAt(null)->count('id');
      $countprojects = Project::whereDeletedAt(null)->count('id');
      $counttasks = Task::whereDeletedAt(null)->count('id');
      $countcustomer = Customer::whereDeletedAt(null)->count('id');
      $countavailables = Available::whereDeletedAt(null)->count('id');
      // EVENTSCALENDAR
      $events = [];
          $data   = Task::all();

          if($data->count())
          {
              foreach ($data as $key => $value)
              {
                  $events[] = Calendar::event(
                      $value->user->name . ' ' . $value->project->projectname ,
                      false,
                      new \DateTime($value->startdate.$value->starttime),
                      new \DateTime($value->enddate.$value->endtime),
                      null,
                      ['color' => $value->user->color,
                      'textcolor' => '#000',
                      'url' => 'planner/tasks/'. $value->id,]
                  );
              }
          }

          $calendar = Calendar::addEvents($events)->setOptions(['lang' =>'nl']);
      return view('planner.index', compact('customers','projects','tasks','users','countcustomer','countprojects','counttasks','countusers','calendar'));
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
