<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PacientesSeeder::class);
        $this->call(AcompanantesSeeder::class);
        $this->call(TratamientosSeeder::class);
        $this->call(LaboratoriosSeeder::class);
        $this->call(MedicamentosSeeder::class);
    }
}
