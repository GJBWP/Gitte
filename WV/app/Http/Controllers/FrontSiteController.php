<?php

namespace App\Http\Controllers;

use App\Action;
use App\Calendar;
use App\Category;
use App\Contact;
use App\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontSiteController extends Controller
{
    public function winkels(){
        $fashion = Store::whereCategory_id(1)->get()->all();
        $bloemen = Store::whereCategory_id(2)->get()->all();
        $food = Store::whereCategory_id(3)->get()->all();
        $nonfood = Store::whereCategory_id(4)->get()->all();
        $diensten   = Store::whereCategory_id(5)->get()->all();
        $categories = Category::all();
        return view('winkels', compact('fashion','bloemen','food','nonfood','diensten','categories'));
    }
    public function bestuur(){
        return view('bestuur');
    }
    public function overons(){
        return view('overons');
    }
    public function activiteiten(){
        $fashion = Store::whereCategory_id(1)->get()->all();
        $bloemen = Store::whereCategory_id(2)->get()->all();
        $food = Store::whereCategory_id(3)->get()->all();
        $nonfood = Store::whereCategory_id(4)->get()->all();
        $diensten   = Store::whereCategory_id(5)->get()->all();
        $actions = Action::where('from', '>=', Carbon::now('Europe/Amsterdam'))->where('till','>=',Carbon::now('Europe/Amsterdam'))->orderBy('from', 'asc')->get()->all();
        $calendars = Calendar::where('date', '>=', Carbon::now('Europe/Amsterdam'))->orderBy('date', 'asc')->get()->all();
        return view('activiteiten', compact('fashion','bloemen','food','nonfood','diensten','actions','calendars'));
    }
    public function contact(){
        return view('contact');
    }
    public function indexhome(){
        return view('indexhome');
    }
    public function backsite(){
        $countstores = Store::whereDeletedAt(null)->count('id');
        $countcalendars = Calendar::whereDeletedAt(null)->count('id');
        $countactions = Action::whereDeletedAt(null)->count('id');
        $countcontacts = Contact::whereDeletedAt(null)->count('id');
        return view('/backsite/index', compact('countactions','countcalendars','countcontacts','countstores'));
    }
}
