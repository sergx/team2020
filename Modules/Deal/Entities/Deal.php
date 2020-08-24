<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
  use \App\Traits\Multitenantable;
  use \App\Traits\commonModelTrait;

  protected $fillable = [
    'material_name',
    'material_volume',
    'material_place',
    'material_description',
    'seller_name',
    'seller_phone',
    'seller_price',
    'seller_description',
    'buyer_name',
    'buyer_phone',
    'buyer_price',
    'buyer_description',
    'status',
  ];
  protected $casts = [
    'images' => 'array',
  ];

  public function DealLog(){
    return $this->hasMany('Modules\Deal\Entities\DealLog');
  }

  public function DealProp(){
    return $this->hasMany('Modules\Deal\Entities\DealProps');
  }

  public function Notification()
  {
      return $this->morphMany('Modules\Notification\Entities\Notification', 'model', 'model_type', 'model_id');
  }

  public function User(){
    return $this->belongsTo('App\User');
  }

  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }

  public function Buyer()
  {
    return $this->belongsToMany('Modules\Buyer\Entities\Buyer', 'deal_buyer', 'deal_id', 'buyer_id');
  }

  public function MaterialRezerv()
  {
    return $this->belongsToMany('Modules\MaterialRezerv\Entities\MaterialRezerv', 'deal_materialrezerv', 'deal_id', 'materialrezerv_id');
  }

  public function MaterialSklad()
  {
    return $this->belongsToMany('Modules\MaterialSklad\Entities\MaterialSklad', 'deal_materialsklad', 'deal_id', 'materialsklad_id');
  }

  public function getDealName()
  {
    $MaterialSklad = $this->MaterialSklad()->first();
    $MaterialRezerv = $this->MaterialRezerv()->first();
    $Buyer = $this->Buyer()->first();
    $dealName = "Сделка от " . date("d-m-Y, H:i" , strtotime($this->attributes['created_at']));
    if(!empty($MaterialSklad)){
      $dealName .= " — ".$MaterialSklad->name . ": ". $this->seller_name . "<small>" . $this->attributes['seller_price'] .  "</small> -> " . $Buyer->name . "<small>" . $this->attributes['buyer_price'] .  "</small>";
    }elseif(!empty($MaterialRezerv)){
      $dealName .= " — ".$MaterialRezerv->name . ": ". $this->seller_name . "<small>" . $this->attributes['seller_price'] .  "</small> -> " . $Buyer->name . "<small>" . $this->attributes['buyer_price'] .  "</small>";
    }
    return $dealName;
  }


  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  // }
}
