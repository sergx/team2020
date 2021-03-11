<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTeamUserResoursesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //
    Schema::table('team_user_resourses', function (Blueprint $table) {
      $table->bigInteger('unic_id')->nullable()->unsigned();
      $table->bigInteger('user_id')->nullable()->unsigned()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('team_user_resourses', function (Blueprint $table) {
      $table->dropColumn('unic_id');
    });
  }
}
