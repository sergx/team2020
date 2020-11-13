<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePunktPriemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('team_punkt_priem', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable();
      $table->string('name')->nullable();
      $table->string('address')->nullable();
      $table->string('description')->nullable();
      $table->string('place')->nullable();
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
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
    Schema::dropIfExists('team_punkt_priem');
  }
}
