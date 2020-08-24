<?php

namespace Modules\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  protected $fillable = [];

  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }
  
  public function Deals()
  {
    return $this->belongsToMany('Modules\Deal\Entities\Deal', 'deal_buyer');
  }
}
