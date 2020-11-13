<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasContractToBuyersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('team_buyers', function (Blueprint $table) {
      $table->boolean('has_contract')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('team_buyers', function (Blueprint $table) {
      $table->dropColumn('has_contract');
    });
  }
}
