<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasContractToSellersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('sellers', function (Blueprint $table) {
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
    Schema::table('sellers', function (Blueprint $table) {
      $table->dropColumn('has_contract');
    });
  }
}
