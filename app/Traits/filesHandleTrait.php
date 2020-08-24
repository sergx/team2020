<?php

namespace App\Traits;

use Modules\File\Entities\File;

trait filesHandleTrait {

  public static function storeFiles($files, string $folder_store = 'other_files/')
  {
    $file_paths = [];
    foreach ($files as $file) {
      $extention = $file->getClientOriginalExtension();
      $fileNameToStore = $folder_store . sha1_file($file).".".$extention;
      $file->storeAs('public', $fileNameToStore);
      $file_paths[] = "/storage/".$fileNameToStore;
    }
    return $file_paths;
  }

  public static function storeModelFiles($files, $model = false, string $folder_store = 'other_files/'){
    foreach ($files as $file) {
      // Имя и расширение файла
      $filenameWithExt = $file->getClientOriginalName();
      // Только оригинальное имя файла
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

      $extention = $file->getClientOriginalExtension();
      $fileNameToStore = $folder_store . sha1_file($file).".".$extention;
      $file->storeAs('public', $fileNameToStore);
      if($model !== false && isset($model->Files)){
        $newFile = new File([
          'filename' => $filename,
          'path' => "/storage/".$fileNameToStore,
          'fileable_type' => $model->getClassNamespace(),
          'fileable_id' => $model->id
          ]);
        $model->Files()->save($newFile);
      }else{
        throw new Exception("Error App\Traits\filesHandleTrait", 1);
      }
    }
  }
}
