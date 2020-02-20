<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCustomer;
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
use App\Http\Controllers\CustomDownloadController;



class PlannerCustomersController extends Controller
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
      $customers = Customer::orderBy('companyname', 'ASC')->paginate(20);
      $projects = Project::all();
      $tasks = Task::all();
      $users = User::all();
      $countusers = User::count('id');
      $countprojects = Project::count('id');
      $counttasks = Task::count('id');
      $countcustomer = Customer::count('id');

      return view('planner.customers.index', compact('customers','projects','tasks','users','countcustomer','countprojects','counttasks','countusers'))
          ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                return view('planner.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $validated = $request->validated();
        Customer::create($request->all());
        return redirect('planner/customers')->with('success', 'Klant toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $projects = Project::whereCustomerId($id)->get()->all();

        return view('planner.customers.show',['customer' => Customer::findOrFail($id)], compact('projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $customers = Customer::findOrFail($id);
      return view('planner.customers.edit',compact('customers'));
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
        Customer::whereId($id)->first()->update($input);

        return redirect('planner/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Customer::findOrFail($id)->delete();
      return redirect('planner/customers');
    }
}
