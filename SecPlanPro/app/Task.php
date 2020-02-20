<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
  use SoftDeletes;
  protected $table = 'tasks';
  protected $fillable = [
      'project_id', 'user_id', 'remarks','startdate','starttime','enddate','endtime','planned_hours','break'
  ];
 protected $softDelete = true;
  public function role(){
    return $this->belongsTo('App\Role');
  }
  public function project(){
    return $this->belongsTo('App\Project')->withTrashed();
  }
  public function customer(){
    return $this->belongsTo('App\Customer')->withTrashed();
  }
  public function user(){
    return $this->belongsTo('App\User')->withTrashed();
  }
  public function hour(){
    return $this->belongsTo('App\Hour');
  }
}
