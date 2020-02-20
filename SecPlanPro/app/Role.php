<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
  use SoftDeletes;

    protected $fillable = [
        'name',
    ];
 protected $softDelete = true;
    public function customer(){
      return $this->belongsTo('App\Customer');
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
}
