<?php

namespace App\Traits;

use Modules\File\Entities\File;

trait filesHandleTrait {

  public function storeFiles($files, string $folder_name = 'other_files/')
  {
    $file_paths = [];
    foreach ($files as $file) {

      $unicFilename = $this->getUnicFilename($file, $folder_name, "public");
      //$extention = $file->getClientOriginalExtension();
      //$fileNameToStore = $folder_name . sha1_file($file).".".$extention;
      $file->storeAs('public', $unicFilename['file_path']);
      $file_paths[] = "/storage/".$unicFilename['file_path'];
    }
    return $file_paths;
  }

  public static function storeModelFiles($files, $model = false, string $folder_name = 'other_files/'){
    foreach ($files as $file) {
      if($model !== false && isset($model->Files)){
        $folder_name = strtolower(class_basename($model)."/".$model->id."/");
        $unicFilename = \App\Traits\filesHandleTrait::getUnicFilename($file, $folder_name, "public");

        $file->storeAs('public', $unicFilename['file_path']);
        $newFile = new File([
          'filename' => $unicFilename['filenameWithExt'],
          'path' => "/storage/".$unicFilename['file_path'],
          'fileable_type' => get_class($model),
          'fileable_id' => $model->id
          ]);
        $model->Files()->save($newFile);
      }else{
        throw new Exception("Error App\Traits\filesHandleTrait", 1);
      }
    }
  }

  public static function getUnicFilename($file, $folder_name, $disc = "public"){
    $filenameWithExt = $file->getClientOriginalName();
    $filename = \League\Flysystem\Util::normalizePath(pathinfo($filenameWithExt, PATHINFO_FILENAME));
    $extention = $file->getClientOriginalExtension();
    $filenameWithExt = $filename.".".$extention;

    $file_path = $folder_name.$filenameWithExt;
    $postfix = 1;
    while(\Storage::disk($disc)->exists($file_path)){
      $filenameWithExt = $filename."-".$postfix.".".$extention;
      $file_path = $folder_name.$filenameWithExt;
      $postfix++;
    }
    return ['file_path' => $file_path, 'filenameWithExt' => $filenameWithExt];
  }
}
