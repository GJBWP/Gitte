<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use DateTime;
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
use Illuminate\Support\Facades\Mail;
use Spatie\CalendarLinks\Link;

class PlannerTasksController extends Controller
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
      $projects = Project::orderBy('startdate')->get()->all();
      $tasks = Task::orderBy('startdate')->get()->all();
      $users = User::all();
      $countusers = User::count('id');
      $countprojects = Project::count('id');
      $counttasks = Task::count('id');
      $countcustomer = Customer::count('id');

      return view('planner.tasks.index', compact('customers','projects','tasks','users','countcustomer','countprojects','counttasks','countusers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('planner.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreTask $request)
    {
        //Constructing googleUrl
//        $task= Task::findOrFail($id);
//        $dateTimeFormat = 'Ymd', "Ymd\THis";
        $start = $request->startdate . $request->starttime;
        $van = DateTime::createFromFormat('Y-m-d H:i:s', $start );
        $startdate = $van->format('Ymd\THis');
        $end = $request->enddate . $request->endtime;
        $tot = DateTime::createFromFormat('Y-m-d H:i:s', $end );
        $enddate = $tot->format('Ymd\THis');
        $timezone = 'Europe/Amsterdam';
        $projectFind = Project::findOrFail($request->project_id);
        $description = $projectFind->projectname . " - " .$projectFind->description . " - " .$request->remarks. " - " .$projectFind->clothing;
        $googleUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
//        $dateTimeFormat = $request->allDay ? 'Ymd' : "Ymd\THis";
        $googleUrl .= '&text='.urlencode($projectFind->projectname);
        $googleUrl .= '&dates='.$startdate.'/'.$enddate;
        $googleUrl .= '&ctz='.$timezone ;
        $googleUrl .= '&details='.$description;
        $googleUrl .= '&location='.$projectFind->address;

        //Constructing Data Array

        $user = User::findOrFail($request->user_id);
        $data['naam'] = $user->name;
        $data['email'] = $user->email;

        $projectnaam = Project::findOrFail($request->project_id);
        $data['project'] = $projectnaam->projectname;
        $data['description'] = $projectnaam->description;
        $data['remarks'] = $request->remarks;
        $data['url'] = env('APP_URL').'/wkn/task/';
        $data['startdate'] = $request->startdate;
        $data['starttime'] = $request->starttime;
        $data['enddate'] = $request->enddate;
        $data['endtime'] = $request->endtime;
        $data['location'] = $projectnaam->address;
        $data['google'] = $googleUrl;
//        $data['to'] = 'taken@secplanpro.nl';
        $data['to'] = 'planner@bureauhofmeijer.nl';
        //Structuring Mail and Sending it


        Mail::send('emails.taskcreated', $data, function($message) use ($data) {

            $message->to($data['email'], $data['naam'])->cc($data['to'])->subject
            ('Nieuwe Taak aangemaakt voor u');
            $message->from('noreply@secplanpro.nl','SecPlanPro');
        });

        //Getting date and time stamps for calculation of time
      $start = Carbon::parse($request->startdate .' '. $request->starttime);
$end = Carbon::parse($request->enddate .' '. $request->endtime);

        //Get the difference in seconds
$difference = $end->diffInSeconds($start);

        //Calculation of breaktime in seconds
        $breakToSeconds = date_parse($request->break);
        $breakseconds = $breakToSeconds['hour'] * 3600 + $breakToSeconds['minute'] * 60 + $breakToSeconds['second']; //3600

        //Calculating worktime
        $differenceMinusBreak = $difference - $breakseconds;

        //Setting worktime
        $request['planned_hours'] = $differenceMinusBreak; //27000

      Task::create($request->all());

      $tasks = Task::whereProjectId($request->project_id)->get()->all();
      $users = User::pluck('name','id')->all();
      $hours = Hour::whereProjectId($request->project_id)->get()->all();
      $availables = Available::whereProjectId($request->project_id)->get()->all();
      $sumtaskhours = Task::whereProjectId($request->project_id)->sum('planned_hours');
      $sumhourhours = Hour::whereProjectId($request->project_id)->sum('worked_hours');

        return view('planner.projects.show', ['project' => Project::findOrFail($request->project_id)], compact('users', 'tasks', 'hours','availables','sumtaskhours','sumhourhours'))->with('success', 'Taak toegevoegd');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {



      $task = Task::findOrFail($id);
      $hours = Hour::whereTaskId($id)->get()->all();
      $project = Project::whereId($task->project_id)->get()->all();
        $customer = Customer::whereId($task->project->customer_id)->get()->all();
    return view('planner.tasks.show',['task'=>Task::findOrFail($id)], compact('project','customer','hours'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
      $task = Task::findOrFail($id);
      $project = Project::whereId($task->project_id)->get()->all();
        $customer = Customer::whereId($task->project->customer_id)->get()->all();
  $users = User::pluck('name','id')->all();
        return view('planner.tasks.edit', compact('task','project','customer','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
      $input = $request->all();
        $start = Carbon::parse($request->startdate .' '. $request->starttime);
        $end = Carbon::parse($request->enddate .' '. $request->endtime);
        $difference = $end->diffInSeconds($start); //30600
//        $breakseconds = Carbon::createFromTimestamp($request->break)->format('s');
        $breakToSeconds = date_parse($request->break);
        $breakseconds = $breakToSeconds['hour'] * 3600 + $breakToSeconds['minute'] * 60 + $breakToSeconds['second']; //3600
        $differenceMinusBreak = $difference - $breakseconds;
        $input['planned_hours'] = $differenceMinusBreak; //27000
//        dd($difference, $differenceMinusBreak, $breakseconds, $request->planned_hours);
      Task::whereId($id)->first()->update($input);

      return redirect('planner/projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Task::findOrFail($id)->delete();
      return redirect('planner/projects');
    }
}
