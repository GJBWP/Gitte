<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class planner extends Model
{
  use SoftDeletes;
 protected $softDelete = true;
  public function role(){
    return $this->belongsTo('App\Role');
  }
  public function project(){
    return $this->belongsTo('App\Project');
  }
  public function task(){
    return $this->belongsTo('App\Task');
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
  public function customer(){
    return $this->belongsTo('App\Customer');
  }

}
