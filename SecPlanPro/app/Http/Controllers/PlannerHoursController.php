<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreHour;
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
use App\Exports\HoursExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;


class PlannerHoursController extends Controller
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

      $hours = Hour::orderBy('project_id')->get()->all();
        return view('planner.hours.index', compact('hours'));
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
    public function store(StoreHour $request)
    {
      $start = Carbon::parse($request->workedstartdate . $request->workedstarttime);
$end = Carbon::parse($request->workedenddate . $request->workedendtime);
        $difference = $end->diffInSeconds($start);
        $breakToSeconds = date_parse($request->workedbreak);
        $breakseconds = $breakToSeconds['hour'] * 3600 + $breakToSeconds['minute'] * 60 + $breakToSeconds['second']; //3600
        $worked_hours = $difference-$breakseconds;
    $hour = Hour::create([
        'project_id' => $request['project_id'],
            'customer_id' => $request['customer_id'],
        'task_id' => $request['task_id'],
        'user_id' => $request['user_id'],
        'workedstartdate' => $request['workedstartdate'],
        'workedstarttime' => $request['workedstarttime'],
        'workedenddate' => $request['workedenddate'],
        'workedendtime' => $request['workedendtime'],
        'workedbreak' =>$request['workedbreak'],
        'worked_hours' => $worked_hours,
      ]);
Task::whereId($request['task_id'])->update(['hour_id'=>$hour->id]);

$hours = Hour::whereId($request->hour_id)->get()->all();
$users = User::pluck('name','id')->all();
    return view('planner.tasks.show', ['task' => Task::findOrFail($request->task_id)], compact('users', 'hours'));
      // return $request->worked_hours;
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
      {
        $task = Task::findOrFail($id);
        $project = Project::whereId($task->project_id)->get()->all();
          $customer = Customer::whereId($task->project->customer_id)->get()->all();
      return view('planner.hours.create',['task'=>Task::findOrFail($id)], compact('project','customer','task'));
      }
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

        $start = Carbon::parse($request->workedstartdate . $request->workedstarttime);
  $end = Carbon::parse($request->workedenddate . $request->workedendtime);
        $difference = $end->diffInSeconds($start);
        $breakToSeconds = date_parse($request->workedbreak);
        $breakseconds = $breakToSeconds['hour'] * 3600 + $breakToSeconds['minute'] * 60 + $breakToSeconds['second']; //3600
        $worked_hours = $difference-$breakseconds;
      $hour = Hour::whereId($id)->first()->update([
          'project_id' => $request['project_id'],
              'customer_id' => $request['customer_id'],
          'task_id' => $request['task_id'],
          'user_id' => $request['user_id'],
          'workedstartdate' => $request['workedstartdate'],
          'workedstarttime' => $request['workedstarttime'],
          'workedenddate' => $request['workedenddate'],
          'workedendtime' => $request['workedendtime'],
          'workedbreak' =>$request['workedbreak'],
          'worked_hours' => $worked_hours,
        ]);
  $hours = Hour::whereId($request->hour_id)->get()->all();
  $users = User::pluck('name','id')->all();
      return view('planner.tasks.show', ['task' => Task::findOrFail($request->task_id)], compact('users', 'hours'));
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
