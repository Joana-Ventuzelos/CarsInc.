<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert localizacoes data
        DB::table('localizacoes')->insert([
            ['bem_locavel_id' => 1, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['bem_locavel_id' => 2, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
            ['bem_locavel_id' => 3, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A3'],
            ['bem_locavel_id' => 4, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B1'],
            ['bem_locavel_id' => 5, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B2'],
            ['bem_locavel_id' => 6, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B2'],
            ['bem_locavel_id' => 7, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A1'],
            ['bem_locavel_id' => 8, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A3'],
            ['bem_locavel_id' => 9, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B1'],
            ['bem_locavel_id' => 10, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A1'],
            ['bem_locavel_id' => 11, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A1'],
            ['bem_locavel_id' => 12, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A2'],
            ['bem_locavel_id' => 13, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A2'],
            ['bem_locavel_id' => 14, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B3'],
            ['bem_locavel_id' => 15, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B2'],
            ['bem_locavel_id' => 16, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A2'],
            ['bem_locavel_id' => 17, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A4'],
            ['bem_locavel_id' => 18, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C1'],
            ['bem_locavel_id' => 19, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A1'],
            ['bem_locavel_id' => 20, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B1'],
            ['bem_locavel_id' => 21, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B1'],
            ['bem_locavel_id' => 22, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A4'],
            ['bem_locavel_id' => 23, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A5'],
            ['bem_locavel_id' => 24, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A2'],
            ['bem_locavel_id' => 25, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C1'],
            ['bem_locavel_id' => 26, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A3'],
            ['bem_locavel_id' => 27, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B2'],
            ['bem_locavel_id' => 28, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C2'],
            ['bem_locavel_id' => 29, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B3'],
            ['bem_locavel_id' => 30, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C2'],
        ]);
    }
}
