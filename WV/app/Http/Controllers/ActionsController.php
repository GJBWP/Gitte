<?php

namespace App\Http\Controllers;
use App\Store;
use App\Action;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  $stores = Store::pluck('companyname','id')->all();
        $actions = Action::all();
        return view('backsite.actions.index', compact('actions','stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  $stores = Store::pluck('companyname','id')->all();
        return view('backsite.actions.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if($file = $request->file('flyer')){
            $name = $request->name . $file->getClientOriginalExtension();
            $file->move('images\actions', $name);
            $input->logo = $name;
        }
        Action::create($input);
        return redirect('/backsite/actions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  $stores = Store::pluck('companyname','id')->all();
        $actions = Action::findOrFail($id);
        return view('backsite/actions/show',['action' => Action::findOrFail($id)], compact('actions','stores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actions = Action::findOrFail($id);
        return view('backsite.actions.edit', compact('actions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { $stores = Store::pluck('companyname','id')->all();
        $input = $request->all();
        if($file = $request->file('flyer')){
            $name = $request->name . $file->getClientOriginalExtension();
            $file->move('images\actions', $name);
            $input->logo = $name;
        }
        Action::whereId($id)->first()->update($input);
        return redirect('/backsite/actions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Action::findOrFail($id)->delete();
        return redirect('/backsite/actions');
    }
}
