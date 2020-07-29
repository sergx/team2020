<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
  protected $fillable = [];
  //public $class_basename = get_class($this);
  public $class_basename = "Deal";

  public function DealLog(){
    return $this->hasMany('Modules\Deal\Entities\DealLog');
  }

  public function DealProp(){
    return $this->hasMany('Modules\Deal\Entities\DealProps');
  }

  // public function Notification(){
  //   return $this->hasMany('Modules\Notification\Entities\Notification', 'model_id', 'id');
  // }

  public function Notification()
  {
      return $this->morphMany('Modules\Notification\Entities\Notification', 'model', 'model_type', 'model_id');
  }

  public function User(){
    return $this->belongsTo('App\User');
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
