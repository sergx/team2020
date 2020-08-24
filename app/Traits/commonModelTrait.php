<?php

namespace App\Traits;

trait commonModelTrait {
  
  // Чтобы получить строку типа "Modules\File\Entities\File"
  // $this->getClassNamespace();
  public function getClassNamespace(){
    $rc = new \ReflectionClass($this);
    $namespace = $rc->getNamespaceName();
    if($namespace){
      $namespace .= "\\";
    }
    $namespace .= $rc->getShortName();
    return $namespace;
  }


  
}
