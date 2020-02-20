<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use SoftDeletes;
  use \Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
 protected $softDelete = true;
protected $softCascade = ['project'];
  protected $fillable = [
      'companyname', 'companycontact', 'phone','email','website','postaddress','visitaddress','kvknumber','btwnumber',
  ];

  public function role(){
    return $this->belongsTo('App\Role')
        ->withTrashed();
  }
  public function project(){
    return $this->hasMany('App\Project')
        ->withTrashed();
  }
  public function task(){
    return $this->belongsTo('App\Task')
        ->withTrashed();
  }
  public function user(){
    return $this->belongsTo('App\User')
        ->withTrashed();
  }





}
