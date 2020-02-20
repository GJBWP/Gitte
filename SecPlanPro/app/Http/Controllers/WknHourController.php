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
use Auth;



class WknHourController extends Controller
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
      $hours = Hour::whereUserId(Auth::user()->id)->get()->all();
        return view('wkn.hour.index', compact('hours'));
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
        'task_id' => $request['task_id'],
        'customer_id' => $request['customer_id'],
        'user_id' => $request['user_id'],
        'workedstartdate' => $request['workedstartdate'],
        'workedstarttime' => $request['workedstarttime'],
        'workedenddate' => $request['workedenddate'],
        'workedendtime' => $request['workedendtime'],
        'workedbreak' => $request['workedbreak'],
        'worked_hours' => $worked_hours,
      ]);
Task::whereId($request['task_id'])->update(['hour_id'=>$hour->id]);

$hours = Hour::whereId($request->hour_id)->get()->all();
$users = User::pluck('name','id')->all();
    return view('wkn.task.show', ['task' => Task::findOrFail($request->task_id)], compact('users', 'hours'));
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
