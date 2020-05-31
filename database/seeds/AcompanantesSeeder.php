<?php

use Illuminate\Database\Seeder;
use Ace\Acompanante;

class AcompanantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Acompanante::class, 20)->create();
    }
}
