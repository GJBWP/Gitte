<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = ['companyname','address1','address2','email','phone','website','category_id','logo'];

    public function category(){
      return $this->belongsTo('App\Category');
    }

    public function action(){
      return $this->belongsTo('App\Action');
    }
}
