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
use Auth;


class WknController extends Controller
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
      $userid = Auth::user()->id;
      $customers = Customer::all();
      $projects = Project::whereAvailable('ja')->get()->all();
      $tasks = Task::whereUserId($userid)->get()->all();
      $users = User::all();
      $countusers = User::whereDeletedAt(null)->count('id');
      $countprojects = Project::whereDeletedAt(null)->whereAvailable('ja')->count('id');
      $counttasks = Task::whereDeletedAt(null)->whereUserId($userid)->count('id');
      $countavailables = Available::whereDeletedAt(null)->whereUserId($userid)->count('id');
      $countcustomers = Customer::whereDeletedAt(null)->count('id');

      // EVENTSCALENDAR
      $events = [];
          $data = Task::whereUserId($userid)->get()->all();
$data = $tasks;
          if($counttasks)
          {
              foreach ($tasks as $key => $value)
              {
                  $events[] = Calendar::event(
                     $value->project->projectname ,
                      false,
                      new \DateTime($value->startdate.$value->starttime),
                      new \DateTime($value->enddate.$value->endtime),
                      null,
                      ['color' => $value->user->color,
                      'textcolor' => '#000',
                      'url' => 'wkn/task/'. $value->id,]
                  );
              }
          }

        $calendar = Calendar::addEvents($events)->setOptions(['lang' =>'nl']);
      return view('wkn.index', compact('customers','projects','tasks','users','countcustomers','countprojects','counttasks','countusers','countavailables','calendar'));
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
