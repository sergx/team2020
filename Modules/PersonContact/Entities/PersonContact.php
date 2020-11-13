<?php

namespace Modules\PersonContact\Entities;

use Illuminate\Database\Eloquent\Model;

class PersonContact extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [
    'name',
    'phone',
    'email',
    'contactable_type',
    'contactable_id',
  ];

  protected $table = "team_person_contacts";

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
  public function contactable()
  {
    return $this->morphTo();
  }
}
