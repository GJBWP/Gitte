<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Available extends Model
{
  use SoftDeletes;
  use \Illuminate\Database\Eloquent\SoftDeletes;
   protected $softDelete = true;
  protected $fillable = [
    'project_id','user_id'
  ];
  public function project(){
    return $this->belongsTo('App\Project');
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
}
