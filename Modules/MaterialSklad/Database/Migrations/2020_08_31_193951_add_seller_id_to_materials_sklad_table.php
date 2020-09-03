<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellerIdToMaterialsSkladTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('materials_sklad', function (Blueprint $table) {
      $table->string('seller_id')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('materials_sklad', function (Blueprint $table) {
      $table->dropColumn('seller_id');
    });
  }
}
