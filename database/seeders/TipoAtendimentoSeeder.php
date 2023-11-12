<?php

namespace Database\Seeders;

use App\Models\TipoAtendimento;
use Illuminate\Database\Seeder;

class TipoAtendimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAtendimento::create(['nome' => 'Admissional']);
        TipoAtendimento::create(['nome' => 'Demissional']);
        TipoAtendimento::create(['nome' => 'Periódico Anual']);
    }
}