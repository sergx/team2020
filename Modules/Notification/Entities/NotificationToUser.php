<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class notificationToUser extends Model
{
  use \App\Traits\commonModelTrait;

  public $timestamps = false;
  protected $fillable = ['user_id','notification_id'];

  protected $table = "team_notification_to_users";

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
