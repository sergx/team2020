<?php

namespace App\Traits;

trait commonModelTrait {
  
  // Чтобы получить строку типа "Modules\File\Entities\File"
  // $this->getClassNamespace();
  // public function getClassNamespace(){
  //   // Эквивалент get_class($model);

  //   $rc = new \ReflectionClass($this);
  //   $namespace = $rc->getNamespaceName();
  //   if($namespace){
  //     $namespace .= "\\";
  //   }
  //   $namespace .= $rc->getShortName();
  //   return $namespace;
  // }

  public function getClassShort(){
    $rc = new \ReflectionClass($this);
    return $rc->getShortName();
  }

  public function getClassShortLower(){
    $rc = new \ReflectionClass($this);
    return strtolower($rc->getShortName());
  }
  
}
