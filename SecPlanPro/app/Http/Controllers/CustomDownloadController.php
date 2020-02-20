<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
use App\Exports\HoursExport;
use Rap2hpoutre\FastExcel\FastExcel;

class CustomDownloadController extends Controller
{

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

   public function exporthours($id)
   {
     // $export = new HoursExport();
     // $export->setId($id);
     //
     // Excel::download($export, 'hours {{$id}}.xlsx');
     $hours = Hour::whereProjectId($id)->get();
     (new FastExcel($hours))->export('uren'.$id.'.xlsx', function ($hour) {
    return [
      'Project' => $hour->project->projectname . ' '.$hour->project->customer->companyname,
        'Naam' => $hour->user->name,
        'Van' => date('d-m-Y', strtotime($hour->workedstartdate)),
        'Begin' =>  $hour->workedstarttime,
        'Tot' => date('d-m-Y', strtotime($hour->workedenddate)),
        'Eind' => $hour->workedendtime,
        'Totaal' => sprintf('%02d:%02d:%02d', ($hour->worked_hours/3600),($hour->worked_hours/60%60), $hour->worked_hours%60)
    ];
});
return FastExcel($hours)->download('uren'.$id.'.xlsx');
$projects = Project::findOrFail($id);
$tasks = Task::whereProjectId($id)->get()->all();
$users = User::pluck('name','id')->all();
  // $hours = Hour::whereProjectId($id)->get()->all();
  $availables = Available::whereProjectId($id)->get()->all();
  $sumtaskhours = Task::whereProjectId($id)->sum('planned_hours');
  $sumhourhours = Hour::whereProjectId($id)->sum('worked_hours');

return view('planner.projects');




   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function exportuserhours($id)
    {
      // $export = new HoursExport();
      // $export->setId($id);
      //
      // Excel::download($export, 'hours {{$id}}.xlsx');
      $hours = Hour::whereUserId($id)->get();
      (new FastExcel($hours))->export('uren'.$id.'.csv', function ($hour) {
        $name = $hour->user->name;
     return [
                'Naam' => $hour->user->name,
       'Project' => $hour->project->projectname . ' '.$hour->project->customer->companyname,

         'Van' => $hour->workedstartdate . ' ' . $hour->workedstarttime,
         'Tot' => $hour->workedenddate . ' ' . $hour->workedendtime,
         'Totaal' => sprintf('%02d:%02d:%02d', ($hour->worked_hours/3600),($hour->worked_hours/60%60), $hour->worked_hours%60)
     ];
 });
 return FastExcel($hours)->download('uren'.$name.'.csv');

    }

}
