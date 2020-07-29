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
      $table->string('material_name')->nullable();
      $table->string('material_volume')->nullable();
      $table->string('material_place')->nullable();
      $table->text('material_description')->nullable();
      $table->string('seller_name')->nullable();
      $table->string('seller_phone')->nullable();
      $table->string('seller_price')->nullable();
      $table->text('seller_description')->nullable();
      $table->string('buyer_name')->nullable();
      $table->string('buyer_phone')->nullable();
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
      $table->dropColumn('material_name');
      $table->dropColumn('material_volume');
      $table->dropColumn('material_place');
      $table->dropColumn('material_description');
      $table->dropColumn('seller_name');
      $table->dropColumn('seller_phone');
      $table->dropColumn('seller_price');
      $table->dropColumn('seller_description');
      $table->dropColumn('buyer_name');
      $table->dropColumn('buyer_phone');
      $table->dropColumn('buyer_price');
      $table->dropColumn('buyer_description');
    });
  }
}
