<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
  use SoftDeletes;
  use \Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
protected $softCascade = ['task'];
  protected $fillable = [
      'projectname', 'customer_id', 'startdate','starttime','enddate','endtime','description','clothing','address','available','employees','hours_per_employee','hours_total','planned_hours','worked_hours',
  ];
 protected $softDelete = true;
public function role(){
  return $this->belongsTo('App\Role');
}
public function customer(){
  return $this->belongsTo('App\Customer')->withTrashed();
}
public function task(){
  return $this->hasMany('App\Task')->withTrashed();
}
public function user(){
  return $this->belongsTo('App\User')->withTrashed();
}
public function hour(){
  return $this->hasMany('App\Hour')->withTrashed();
}
public function available(){
  return $this->hasMany('App\Available')->withTrashed();
}
}
