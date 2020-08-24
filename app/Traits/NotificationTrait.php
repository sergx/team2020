<?php

namespace App\Traits;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Entities\NotificationToUser;
//use App\User;

trait NotificationTrait {

  public static function addNotification(string $model_type, int $model_id, array $options, $user_id = false)
  {
    $notification = Notification::create([
      'model_type' => $model_type,
      'model_id' => $model_id,
      'user_id' => $user_id ? $user_id : auth()->user()->id,
      'options' => $options,
    ]);
    $notification->save();

    // Получаем список пользователей, для которых это уведомление
    switch($model_type){
      case 'Modules\Deal\Entities\Deal':
        if(auth()->user()->hasRole('admin')){

        }elseif(auth()->user()->hasRole('agent')){
          // Для админов
          $users_to_notify = \App\User::role('admin')->pluck('id');
        }
      break;
    }
    if(!empty($users_to_notify) && count($users_to_notify)){
      foreach($users_to_notify as $user_id){
        $note_to_user = NotificationToUser::create([
          'user_id' => $user_id,
          'notification_id' => $notification->id,
        ]);
        $note_to_user->save();
      }
    }
    


  }
}
