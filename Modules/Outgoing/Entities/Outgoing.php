<?php

namespace Modules\Outgoing\Entities;

use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [
    'user_id',
    'name',
  ];

  protected $table = "team_outgoings";

  public function OutgoingCosts(){
    return $this->hasMany('Modules\Outgoing\Entities\OutgoingCost');
  }

  public function User(){
    return $this->belongsTo('App\User');
  }

  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }
  
  public function getTotalCostAttribute(){
    return $this->OutgoingCosts()->sum('cost_rub');
  }
  
  public function getTotalDescriptionAttribute(){
    if(count($this->OutgoingCosts) > 1){
      $multiple_description = [];
      foreach($this->OutgoingCosts as $item){
        $multiple_description[] = $item->description;
      }
      return implode(" | ",$multiple_description);
    }else{
      return $this->OutgoingCosts()->first()->description;
    }
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
