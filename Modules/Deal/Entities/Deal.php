<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
  use \App\Traits\commonModelTrait;
  use \App\Traits\Multitenantable;

  protected $fillable = [
    //'materialrezerv_id',
    //'materialsklad_id',
    //'seller_id',
    'seller_price',
    'seller_description',
    'user_id',
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

  public function Seller()
  {
    return $this->belongsToMany('Modules\Seller\Entities\Seller', 'deal_seller', 'deal_id', 'seller_id');
  }

  public function MaterialRezerv()
  {
    return $this->belongsToMany('Modules\MaterialRezerv\Entities\MaterialRezerv', 'deal_materialrezerv', 'deal_id', 'materialrezerv_id');
  }

  public function MaterialSklad()
  {
    return $this->belongsToMany('Modules\MaterialSklad\Entities\MaterialSklad', 'deal_materialsklad', 'deal_id', 'materialsklad_id');
  }

  public function OutgoingCosts()
  {
    return $this->morphMany('Modules\Outgoing\Entities\OutgoingCost', 'outgoingcostable', 'outgoingcostable_type', 'outgoingcostable_id');
  }

  public function getDealName()
  {
    $MaterialSklad = $this->MaterialSklad()->first();
    $MaterialRezerv = $this->MaterialRezerv()->first();
    $Buyer = $this->Buyer()->first();
    if(!empty($MaterialSklad)){
      $dealName = $MaterialSklad->name . ": ". $this->seller_name . "<small>" . $this->attributes['seller_price'] .  "</small> -> " . $Buyer->name . "<small> " . $this->attributes['buyer_price'] .  "</small>";
    }elseif(!empty($MaterialRezerv)){
      $dealName = $MaterialRezerv->name . ": ". $this->seller_name . "<small>" . $this->attributes['seller_price'] .  "</small> -> " . $Buyer->name . "<small> " . $this->attributes['buyer_price'] .  "</small>";
    }
    $dealName .= " от " . date("d-m-Y, H:i" , strtotime($this->attributes['created_at']));
    return $dealName;
  }
  
  public function getMaterialAttribute()
  {
    $MaterialSklad = $this->MaterialSklad()->first();
    $MaterialRezerv = $this->MaterialRezerv()->first();
    if(!empty($MaterialSklad)){
      return $MaterialSklad;
    }elseif(!empty($MaterialRezerv)){
      return $MaterialRezerv;
    }
  }
  public function getNameAttribute()
  {
      return $this->getDealName();
  }


  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  // }
}
