<?php

use Illuminate\Database\Seeder;
use Ace\Laboratorio;

class LaboratoriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Laboratorio::class, 10)->create();
    }
}
