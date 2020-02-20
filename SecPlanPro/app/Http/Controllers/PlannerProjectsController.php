<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
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
use Excel;
use Illuminate\Support\Facades\Mail;
use PDF;

class PlannerProjectsController extends Controller
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
      $projects = Project::orderBy('startdate')->paginate(15);
      $tasks = Task::orderBy('startdate')->get()->all();
      $users = User::all();


      return view('planner.projects.index', compact('customers','projects','tasks','users'))->with('i', (request()->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $customers = Customer::pluck('companyname','id')->all();
    return view('planner.projects.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        $validated = $request->validated();
      $str_time = $request['hours_per_employee'];

    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

    $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
  $request['hours_total'] = $time_seconds * $request['employees'];

  if ($request->available == 'ja') {
      //Constructing Data Array
    $email = User::pluck('email')->toArray();
      $data['project'] = $request->projectname;
      $data['startdate'] = $request->startdate;
      $data['starttime'] = $request->starttime;
      $data['enddate'] = $request->enddate;
      $data['endtime'] = $request->endtime;
      $data['location'] = $request->address;
      $data['description'] = $request->description;
      $data['url'] = env('APP_URL').'/wkn/project/';

      //Structuring Mail and Sending it
      Mail::send('emails.available', $data, function ($message) use ($email) {
          $message->to($email)->subject
          ('Nieuw Project beschikbaar gesteld');
          $message->from('noreply@secplanpro.nl', 'SecPlanPro');
      });
  }

        $project = Project::create($request->all());
        return redirect('planner/projects/'.$project->id)->with('success', 'Project toegevoegd');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $projects = Project::findOrFail($id);
      $customers = Customer::pluck('companyname','id')->all();
      $tasks = Task::whereProjectId($id)->whereDeletedAt(NULL)->get()->all();
      $users = User::pluck('name','id')->all();
        $hours = Hour::whereProjectId($id)->get()->all();
        $availables = Available::whereProjectId($id)->get()->all();
        $sumtaskhours = Task::whereProjectId($id)->sum('planned_hours');
        $sumhourhours = Hour::whereProjectId($id)->sum('worked_hours');

  return view('planner.projects.show', ['project' => Project::findOrFail($id)], compact('users', 'tasks','hours','availables','sumtaskhours','sumhourhours','customers'));
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $project = Project::findOrFail($id);
          $customers = Customer::pluck('companyname','id')->all();

return view('planner.projects.edit', compact('project','customers'));
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
      $str_time = $request['hours_per_employee'];

    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

    $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
  $input['hours_total'] = $time_seconds * $request['employees'];
      Project::whereId($id)->first()->update($input);

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
      Project::findOrFail($id)->delete();
      return redirect('planner/projects');
    }
    /**
     * Print PDF Function.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export_pdf($id)
      {
        // Fetch all customers from database
        $data = Task::whereProjectId($id)->get();
        // Send data to the view using loadView function of PDF facade
      return view('planner.projects.print', compact('data'));
        // If you want to store the generated pdf to the server then you can use the store function
        $pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        return $pdf->download('aftekenlijst.pdf');
      }

}
