<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;

class DealLog extends Model
{
  protected $fillable = [];

  protected $table = "deal_log";

  public function Deal(){
    return $this->belongsTo('Modules\Deal\Entities\Deal');
  }

  public function User(){
    return $this->belongsTo('App\User');
  }
  
}
