<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;

class DealProps extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [];

  protected $table = "team_deal_props";

  public function DealLog(){
    return $this->belongsTo('Modules\Deal\Entities\Deal');
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
