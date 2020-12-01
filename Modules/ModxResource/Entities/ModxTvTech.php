<?php

namespace Modules\ModxResource\Entities;

use Illuminate\Database\Eloquent\Model;

class ModxTvTech extends Model
{
  use \App\Traits\commonModelTrait;

  protected $fillable = [];

  protected $table = "quzat_site_tmplvars";

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
