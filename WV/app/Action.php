<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    protected $fillable = ['store_id','from','till','description','flyer'];

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
