<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\premio;

class premioSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path("catalogos/ListaRegalos2024.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                premio::create([
                    "numero_premio" => $data[0],
                    "premio" => $data[1],
                    "pm" => $data[2],
                    "pdi" => $data[3],
                ]);   
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
