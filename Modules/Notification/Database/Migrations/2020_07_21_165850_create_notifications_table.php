<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('team_notifications', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable();
      $table->string('model_type')->nullable();
      $table->bigInteger('model_id')->nullable();
      $table->text('options')->nullable(); // массив с формальными и прочими данными
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('team_notifications');
  }
}
