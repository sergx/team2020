<?php

namespace Modules\MaterialRezerv\Entities;

use Illuminate\Database\Eloquent\Model;

class MaterialRezerv extends Model
{
  protected $fillable = [];

  protected $table = 'materials_rezerv';

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
