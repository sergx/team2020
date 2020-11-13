<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealPropsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('team_deal_props', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable();
      $table->bigInteger('deal_id')->nullable();
      $table->string('name')->nullable();
      $table->text('value')->nullable();
      $table->unsignedTinyInteger('status')->nullable();
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
    Schema::dropIfExists('team_deal_props');
  }
}
