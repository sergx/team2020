<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('deal_log', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable();
      $table->bigInteger('deal_id')->nullable();
      $table->text('message')->nullable();
      $table->text('formal_message')->nullable();
      $table->text('formal_key')->nullable();
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
    Schema::dropIfExists('deal_log');
  }
}
