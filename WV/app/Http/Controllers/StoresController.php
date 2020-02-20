<?php

namespace App\Http\Controllers;
use App\Store;
use App\Category;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        return view('backsite.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('backsite.stores.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $input = $request->all();
        if($file = $request->file('logo')){
            $name = $request->companyname. date('Y-m-d').'.' . $file->getClientOriginalExtension();
            $file->move('images/stores', $name);
            // $input->logo = $name;
        }
        Store::create(
          [
            'companyname' => $request->companyname,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' =>$request->website,
            'category_id' => $request->category_id,
            'logo' => $name,
          ]
        );
        return redirect('/backsite/stores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stores = Store::findOrFail($id);
        $categories = Category::pluck('name','id')->all();
        return view('/backsite/stores/show', ['store' => Store::findOrFail($id)], compact('categories','stores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();
        return view('backsite.stores.edit', compact('categories','store'));
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
        if($file = $request->file('logo')){
            $name = date('Y-m-d').'-' . $file->getClientOriginalName();
            $file->move('images/stores', $name);
            // $input->logo = $name;
        }
        Store::whereId($id)->first()->update([            'companyname' => $request->companyname,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'website' =>$request->website,
                    'category_id' => $request->category_id,
                    'logo' => $name,]);
        return redirect('/backsite/stores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Store::findOrFail($id)->delete();
        return redirect('/backsite/stores');
    }
}
