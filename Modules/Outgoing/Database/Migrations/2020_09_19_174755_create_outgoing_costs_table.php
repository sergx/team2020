<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutgoingCostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('outgoing_costs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->tinyInteger('outgoing_id')->nullable();
      $table->text('description')->nullable();
      $table->string('type')->nullable();
      $table->tinyInteger('status')->nullable();
      $table->bigInteger('cost_rub')->default(0);
      $table->integer('outgoingcostable_id')->nullable();
      $table->string('outgoingcostable_type')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('outgoing_costs');
  }
}
