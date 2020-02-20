<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
  use SoftDeletes;

    use Notifiable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
  use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
  protected $softCascade = ['task'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','passnumber','valid_untill','role_id','color','beveiliger','brandwacht','ehbo',
    ];
 protected $softDelete = true;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role(){
      return $this->belongsTo('App\Role');
    }
    public function project(){
      return $this->belongsTo('App\Project')->withTrashed();
    }
    public function task(){
      return $this->hasMany('App\Task')->withTrashed();
    }
    public function customer(){
      return $this->belongsTo('App\Customer')->withTrashed();
    }
    public function hour(){
      return $this->hasMany('App\Hour')->withTrashed();
    }
    public function available(){
      return $this->hasMany('App\Available')->withTrashed();
    }


    public function isPlanner(){
      if($this->role->name == "planner"){
        return true;
      }
      return false;
    }

}
