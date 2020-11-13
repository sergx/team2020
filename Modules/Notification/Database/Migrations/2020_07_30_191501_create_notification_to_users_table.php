<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationToUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('team_notification_to_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id');
      $table->bigInteger('notification_id');
      $table->boolean('viewed')->default(0);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('viewed_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('team_notification_to_users');
  }
}
