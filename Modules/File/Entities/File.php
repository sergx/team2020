<?php

namespace Modules\File\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $fillable = [
    'filename',
    'path',
    'fileable_type',
    'fileable_id',
  ];

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
  public function fileable()
  {
    return $this->morphTo();
  }
}
