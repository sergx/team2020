<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToMaterialsSklad extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('materials_sklad', function (Blueprint $table) {
      $table->string('volume')->nullable();
      $table->string('place')->nullable();
      $table->string('contacts')->nullable();
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
      $table->dropColumn('volume');
      $table->dropColumn('place');
      $table->dropColumn('contacts');
    });
  }
}
