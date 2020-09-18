<?php

namespace Modules\PunktPriem\Entities;

use Illuminate\Database\Eloquent\Model;

class PunktPriem extends Model
{
  protected $fillable = [
    'name',
    'address',
    'description',
    'has_contract',
  ];

  protected $table = "punkt_priem";
  
  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }

  public function PersonContacts()
  {
    return $this->morphMany('Modules\PersonContact\Entities\PersonContact', 'contactable', 'contactable_type', 'contactable_id');
  }
  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
