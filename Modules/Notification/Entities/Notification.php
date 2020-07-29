<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
  protected $fillable = [];
  protected $casts = [
    'options' => 'array',
  ];

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
  
  // public function Deal(){
  //   return $this->hasOne('Modules\Deal\Entities\Deal', 'id', 'model_id');
  // }

  public function model()
  {
    return $this->morphTo();
  }

  public function NotificationViews(){
    return $this->hasMany('Modules\Notification\Entities\NotificationViews' /*, 'id', 'notification_id'*/);
  }

  public function User(){
    return $this->hasOne('App\User', 'id', 'user_id');
  }

}
