<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable {
  
  // предназначен для того, чтобы выводить только пренадлежащие пользователю элементы

  protected static function bootMultitenantable()
  {
    if (auth()->check()) {
      // если пользователь администратор
      if (!auth()->user()->hasRole('admin')) {
      // При создании объекта автоматом добавляем запись
      static::creating(function ($model) {
        $model->user_id = auth()->id();
      });
      
      // выводим только закрепленное за пользователем
      static::addGlobalScope('user_id', function (Builder $builder) {
        $builder->where('user_id', auth()->id());
      });
      }
    }
  }
}
