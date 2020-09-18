<?php

namespace App\Services;

use Modules\Buyer\Entities\Buyer;

class SideMenuService
{
  public function getSubItems($model_key){
    if(request()->routeIs($model_key.'.show')){
      if(strtolower($model_key) !== "user"){
        $model_key_elem = 'Modules\\' .$model_key. '\Entities\\'.$model_key;
      }else{
        $model_key_elem = 'App\User';
      }
      $items = $model_key_elem::take(10)->get();
      return view('chunk.sub-menu', ['items' => $items, 'model_key' => $model_key]);
    }
  }
}
