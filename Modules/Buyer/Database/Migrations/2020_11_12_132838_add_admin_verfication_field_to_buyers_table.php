<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminVerficationFieldToBuyersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('buyers', function (Blueprint $table) {
      $table->boolean('admin_verification')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('buyers', function (Blueprint $table) {
      $table->dropColumn('admin_verification');
    });
  }
}
