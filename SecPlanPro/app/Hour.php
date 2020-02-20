<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
   protected $softDelete = true;
  protected $fillable = [
      'task_id', 'user_id', 'project_id', 'customer_id', 'workedstartdate','workedstarttime','workedenddate','workedendtime','worked_hours','workedbreak'
  ];
  public function task(){
    return $this->belongsTo('App\Task')->withTrashed();
  }
  public function user(){
    return $this->belongsTo('App\User')->withTrashed();
  }
  public function project(){
    return $this->belongsTo('App\Project')->withTrashed();
  }
}
