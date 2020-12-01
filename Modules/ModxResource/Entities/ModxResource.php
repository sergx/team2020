<?php

namespace Modules\ModxResource\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ModxResource extends Model
{
  use \App\Traits\commonModelTrait;

  //public $st_city_id;

  //public $st_material_id;

  protected $guarded = [];
  
  protected $table = "quzat_site_content";

  protected $attributes = ["id", "template", "menutitle", "parent", "st_city_id", "st_material_id", "st_material_price", "st_unpublished"];

  public function __construct($attr_array = [])
  {
    parent::__construct($attr_array);
    foreach($attr_array as $k => $v){
      $this->{$k} = $v;
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope('menuindex', function (Builder $builder) {
      $builder->orderBy('menuindex', 'asc');
    });
  }

  


  //$item->tv(['name' => 'material_id'])->first()->pivot->value;
  public function tv(){
    return $this->belongsToMany(
      'Modules\ModxResource\Entities\ModxTvTech',
      'quzat_site_tmplvar_contentvalues',
      'contentid',
      'tmplvarid'
      )
    ->select(["name"])
    ->where("name","!=", 'seo_synonym')
    ->where("name","!=", 'material_price')
    ->where("name","!=", 'material_id')
    ->where("name","!=", 'city_id')
    ->where("name","!=", 'social_likes')
    ->where("name","!=", 'social_dislikes')
    ->withPivot('value as value');
  }

  public function parent()
  {
    return $this->belongsTo('Modules\ModxResource\Entities\ModxResource', 'parent')/*->where('parent', 0)->with('parent') Рекурсивно вывести*/;
  }

  public function mic()
  {
    //dd($this->st_city_id);
    return $this->hasMany('Modules\ModxResource\Entities\ModxResource', 'st_material_id', 'id')
    ->select(["id", "template", "pagetitle", "st_city_id", "st_material_id", "st_material_price", "st_unpublished"])
    ->with(['tv']);
    //->where("st_city_id","=", $this->st_city_id)
    //->where("template","=", 12)
    ;
  }

  public function base_material()
  {
    return $this->belongsTo('Modules\ModxResource\Entities\ModxResource', 'st_material_id')
    ->select($this->attributes)
    ->with(['tv']);
  }

  //public function material_price()
  //{
  //  return $this->belongsTo('Modules\ModxResource\Entities\ModxResource', 'st_material_id')
  //  ->select("id", "st_material_price");
  //}

  public function child()
  {
    return $this->hasMany('Modules\ModxResource\Entities\ModxResource','parent')/*->with('children') рекурсивно*/;
  }

  public function children()
  {
    return $this->hasMany('Modules\ModxResource\Entities\ModxResource','parent')
    ->select($this->attributes)
    ->with([
      //'mic',
      'children',
      'tv',
      // => function ($child) use ($st_city_id){
      //   return $child->with(["mic_price" => function($mic_price) use ($st_city_id){
      //     return $mic_price->where("st_city_id","=", $st_city_id);
      //   }]);
      // }
    ]);
  }

  // public function PLACEHOLDER(){
  // return $this->hasMany('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->hasOne('Modules\PLACEHOLDER\Entities\PLACEHOLDER');
  // return $this->belongsTo('Modules\Org\Entities\Org');
  // return $this->belongsToMany('Modules\Product\Entities\Product')->withPivot('price', 'quantity')->withTimestamps();
  // return $this->belongsTo('App\User');
  //}
}
