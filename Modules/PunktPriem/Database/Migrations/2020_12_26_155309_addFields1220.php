<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFields1220 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('team_punkt_priem', function (Blueprint $table) {
      $table->boolean('active')->default(0);
      $table->bigInteger('city_id')->nullable();
      $table->string('coords')->nullable();
      $table->string('work_time')->nullable();
      $table->mediumText('materials')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('team_punkt_priem', function (Blueprint $table) {
      $table->dropColumn('active');
    });
  }
}
