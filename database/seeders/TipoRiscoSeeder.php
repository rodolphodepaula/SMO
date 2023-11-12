<?php

namespace Database\Seeders;

use App\Models\TipoRisco;
use Illuminate\Database\Seeder;

class TipoRiscoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRisco::create(['nome' => 'Físico']);
        TipoRisco::create(['nome' => 'Químico']);
        TipoRisco::create(['nome' => 'Sem riscos específicos']);

    }
}