<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class NotificationViews extends Model
{
  protected $fillable = [];

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
  
  public function User(){
    return $this->hasOne('App\User', 'id', 'user_id');
  }

  public function Notification(){
    return $this->hasOne('Modules\Notification\Entities\Notification');
  }
}
