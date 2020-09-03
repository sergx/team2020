<?php

namespace Modules\MaterialSklad\Entities;

use Illuminate\Database\Eloquent\Model;

class MaterialSklad extends Model
{
  protected $fillable = [
    'name',
    'description',
    'place',
    'volume',
    'seller_id',
    'comment',
  ];

  protected $table = 'materials_sklad';

  public function Seller(){
    return $this->belongsTo('Modules\Seller\Entities\Seller');
  }

  public function Files()
  {
    return $this->morphMany('Modules\File\Entities\File', 'fileable', 'fileable_type', 'fileable_id');
  }
  
  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
