<?php

namespace Modules\Outgoing\Entities;

use Illuminate\Database\Eloquent\Model;

class OutgoingCost extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [
    'outgoing_id',
    'description',
    'type',
    'status',
    'cost_rub',
    'outgoingcostable_type',
    'outgoingcostable_id',
  ];

  public $route_base = 'outgoing'; // Чтобы можно было сгенерировать route('outgoing.show'), или ключ словаря

  public function Outgoing(){
    return $this->belongsTo('Modules\Outgoing\Entities\Outgoing');
  }

  public function outgoingcostable()
  {
    return $this->morphTo();
  }
  
  public function getNameAttribute(){
    return $this->Outgoing()->name;
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
