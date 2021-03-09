<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreDeleteToTeamSellersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('team_sellers', function (Blueprint $table) {
      $table->boolean('pre_deleted')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('team_sellers', function (Blueprint $table) {
      $table->dropColumn('pre_deleted');
    });
  }
}
