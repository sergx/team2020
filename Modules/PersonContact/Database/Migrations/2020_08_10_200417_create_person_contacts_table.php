<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonContactsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('person_contacts', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('user_id')->nullable();
      $table->string('name')->nullable();
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
      $table->string('contactable_type')->nullable();
      $table->string('contactable_id')->nullable();

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
    Schema::dropIfExists('person_contacts');
  }
}
