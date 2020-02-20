<?php

namespace App\Http\Controllers;
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
use Auth;

class WknTaskController extends Controller
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
      $tasks = Task::whereUserId(Auth::user()->id)->orderBy('startdate')->get()->all();
    return view('wkn.task.index', compact('tasks'));
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
  return view('wkn.task.show', ['task' => Task::findOrFail($id)]);
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

    /**
     * Added function to create Ics file from scratch.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function Agenda($id)
    {
        //Taak vinden
        $task = Task::findOrFail($id);
        $tasksummary = $task->project->projectname . " - " .$task->project->description . " - " .$task->remarks. " - " .$task->project->clothing;
        //Formaat definieren
        define ('ICAL_FORMAT', 'Ymd\This');
        //Begin definieren
        $icalObject = "BEGIN:VCALENDAR
        VERSION:2.0
        METHOD:PUBLISH";

        //Body definieren
        $icalObject .=
            "BEGIN:VEVENT
            DTSTART:" . date(ICAL_FORMAT, strtotime($task->startdate .$task->starttime)) ."
            DTEND:". date(ICAL_FORMAT, strtotime($task->enddate .$task->endtime)) ."
            DTSTAMP:" . date(ICAL_FORMAT, strtotime($task->created_at))."
            SUMMARY:".$tasksummary."
            UID:". $task->id."
            LOCATION:". $task->project->address."
            END:VEVENT\n";

        $icalObject .= "END:VCALENDAR";

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="Agenda.ics"');
        $icalObject = str_replace(' ', '', $icalObject);

        echo $icalObject;
    }
    public function GoogleAgenda($id) {
        $task= Task::findOrFail($id);
//        $dateTimeFormat = 'Ymd', "Ymd\THis";
        $start = $task->startdate . $task->starttime;
        $van = DateTime::createFromFormat('Y-m-d H:i:s', $start );
        $startdate = $van->format('Ymd\THis');
        $end = $task->enddate . $task->endtime;
        $tot = DateTime::createFromFormat('Y-m-d H:i:s', $end );
        $enddate = $tot->format('Ymd\THis');
        $timezone = 'Europe/Amsterdam';
        $description = $task->project->projectname . " - " .$task->project->description . " - " .$task->remarks. " - " .$task->project->clothing;
        $url = $url = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
        $dateTimeFormat = $task->allDay ? 'Ymd' : "Ymd\THis";
        $url .= '&text='.urlencode($task->project->projectname);
        $url .= '&dates='.$startdate.'/'.$enddate;
        $url .= '&ctz='.$timezone ;
        $url .= '&details='.$description;
        $url .= '&location='.$task->project->address;
//        $url .= '&sprop=&sprop=name:';

//        return $url;
        echo "<script>window.open('".$url."', '_blank')</script>";










    }
}
