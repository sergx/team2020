<?php

namespace Modules\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [
    'name',
    'description',
    'description_material',
    'place',
    'has_contract',
    'admin_verification',
  ];

  protected $table = "team_buyers";

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
    return $this->belongsToMany('Modules\Deal\Entities\Deal', 'team_deal_buyer');
  }
}
