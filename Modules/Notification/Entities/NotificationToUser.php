<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class notificationToUser extends Model
{
  public $timestamps = false;
  protected $fillable = ['user_id','notification_id'];

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
