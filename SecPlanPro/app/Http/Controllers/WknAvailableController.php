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
use Illuminate\Support\Facades\Mail;

class WknAvailableController extends Controller
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
        //
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
        //Constructing Data Array
        $user = User::findOrFail($request->user_id);
        $data['naam'] = $user->name;
        $projectnaam = Project::findOrFail($request->project_id);
        $data['project'] = $projectnaam->projectname;
        $data['url'] = env('APP_URL').'/planner/projects/'.$request->project_id;

        //Structuring Mail and Sending it
        Mail::send('emails.availableadded', $data , function($message) {
            $message->to('info@gjbwebproduction.nl', 'SecPlanPro')->subject
            ('Nieuwe beschikbaarstelling');
            $message->from('noreply@secplanpro.nl','SecPlanPro');
        });

        //Adding form information to Table
      Available::create($request->all());

        //redirect to Projects
      return redirect('wkn/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WknAvailableController  $wknAvailableController
     * @return \Illuminate\Http\Response
     */
    public function show(WknAvailableController $wknAvailableController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WknAvailableController  $wknAvailableController
     * @return \Illuminate\Http\Response
     */
    public function edit(WknAvailableController $wknAvailableController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WknAvailableController  $wknAvailableController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WknAvailableController $wknAvailableController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WknAvailableController  $wknAvailableController
     * @return \Illuminate\Http\Response
     */
    public function destroy(WknAvailableController $wknAvailableController)
    {
        //
    }
}
