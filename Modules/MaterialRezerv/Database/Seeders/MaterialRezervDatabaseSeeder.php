<?php

namespace Modules\MaterialRezerv\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MaterialRezervDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    // $this->call("OthersTableSeeder");
  }
}
