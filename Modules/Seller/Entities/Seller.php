<?php

namespace Modules\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
  use \App\Traits\commonModelTrait;
  
  protected $fillable = [
    'name',
    'place',
    'description',
    'description_material',
    'has_contract',
  ];

  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }

  public function PersonContacts()
  {
    return $this->morphMany('Modules\PersonContact\Entities\PersonContact', 'contactable', 'contactable_type', 'contactable_id');
  }
  
  public function Deals()
  {
    return $this->belongsToMany('Modules\Deal\Entities\Deal', 'deal_seller');
  }

  public function MaterialsSklad(){
    return $this->hasMany('Modules\MaterialSklad\Entities\MaterialSklad');
  }

  public function MaterialsRezerv(){
    return $this->hasMany('Modules\MaterialRezerv\Entities\MaterialRezerv');
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
