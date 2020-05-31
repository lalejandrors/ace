<?php

use Illuminate\Database\Seeder;
use Ace\Tratamiento;

class TratamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tratamiento::class, 10)->create();
    }
}
