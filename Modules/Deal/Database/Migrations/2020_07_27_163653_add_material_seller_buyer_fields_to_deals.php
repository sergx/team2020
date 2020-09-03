<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaterialSellerBuyerFieldsToDeals extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('deals', function (Blueprint $table) {

      $table->string('seller_price')->nullable();
      $table->text('seller_description')->nullable();
      $table->string('buyer_price')->nullable();
      $table->text('buyer_description')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('deals', function (Blueprint $table) {
      $table->dropColumn('seller_price');
      $table->dropColumn('seller_description');
      $table->dropColumn('buyer_price');
      $table->dropColumn('buyer_description');
    });
  }
}
