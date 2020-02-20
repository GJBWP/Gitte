<?php

namespace App\Http\Controllers;


use DateTime;
use Illuminate\Http\Request;
use Spatie\CalendarLinks\Link;
use App\Task;
use App\Project;
use App\Customer;
use App\User;

class IcalController extends Controller
{

    public function Ical($id)
    {
        $task = Task::findOrFail($id);
        $projectnaam = $task->project->projectname;
        $adres = $task->project->address;


        $from = $task->startdate.' '.$task->starttime;
//        $van = strToTime($from);
        $van2 = DateTime::createFromFormat('Y-m-d H:i:s', $from );
        $van = $van2->format('Y-m-d H:i');
        $to = $task->enddate.' '.$task->endtime;

        $tot2 = DateTime::createFromFormat('Y-m-d H:i:s', $to );
        $tot = $tot2->format('Y-m-d H:i');
        $omschrijving = $task->project->description;
        $opmerkingen = $task->remarks;
        $kleding = $task->project->clothing;
        $description = $omschrijving .' - '. $opmerkingen.' - '. $kleding;
//        echo $projectnaam.' - '.$kleding.' - '.$van.' - '.$tot.' - '.$omschrijving.' - '.$opmerkingen.' - '.$adres;
//            echo $van .'-'. $tot.'------'.$from.'-'.$to ;
        $link = Link::create($projectnaam, $van2, $tot2, false)
            ->description($description)->address($adres);
        echo $link->google();
}
}
