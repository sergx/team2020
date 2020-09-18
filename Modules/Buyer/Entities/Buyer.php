<?php

namespace Modules\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  protected $fillable = [
    'name',
    'description',
    'place',
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
    return $this->belongsToMany('Modules\Deal\Entities\Deal', 'deal_buyer');
  }
}
