<?php

use Illuminate\Database\Seeder;
use Ace\Medicamento;

class MedicamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Medicamento::class, 10)->create();
    }
}
