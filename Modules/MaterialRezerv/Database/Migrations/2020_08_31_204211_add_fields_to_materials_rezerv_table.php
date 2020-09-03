<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToMaterialsRezervTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('materials_rezerv', function (Blueprint $table) {
      $table->string('seller_id')->nullable();
      $table->string('volume')->nullable();
      $table->string('place')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('materials_rezerv', function (Blueprint $table) {
      $table->dropColumn('seller_id');
      $table->dropColumn('volume');
      $table->dropColumn('place');
    });
  }
}
