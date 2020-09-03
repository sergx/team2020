<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('buyers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable();
      $table->string('name')->nullable();
      $table->string('description')->nullable();
      $table->string('place')->nullable();
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
    Schema::dropIfExists('buyers');
  }
}
