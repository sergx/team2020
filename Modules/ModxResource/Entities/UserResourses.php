<?php

namespace Modules\ModxResource\Entities;

use Illuminate\Database\Eloquent\Model;

class UserResourses extends Model
{
  use \App\Traits\commonModelTrait;

  // prefix:
  // user        1000000
  // punktpriem  2000000

  //protected $fillable = [];
  protected $guarded = [];
  protected $table = "team_user_resourses";

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
