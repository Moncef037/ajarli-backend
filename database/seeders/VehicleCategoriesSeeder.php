<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['label' => 'Machine de terrassement', 'value' => 'machine_de_terrassement'],
            ['label' => 'Trancheuse et foreuse', 'value' => 'trancheuse_et_foreuse'],
            ['label' => 'Grue et sur camion', 'value' => 'grue_et_sur_camion'],
            ['label' => 'Camion à benne et citerne', 'value' => 'camion_a_benne_et_citerne'],
            ['label' => 'Machine à béton', 'value' => 'machine_a_beton'],
            ['label' => 'Machine routière', 'value' => 'machine_routiere'],
            ['label' => 'Platforme élévatrice', 'value' => 'platforme_elevatrice'],
            ['label' => 'Téléscopique et clark', 'value' => 'telescopique_et_clark'],
            ['label' => 'Service transport', 'value' => 'service_transport'],
            ['label' => 'Attachement', 'value' => 'attachement'],
        ];

        foreach ($data as $item) {
            VehicleCategory::create([
                'label' => $item['label'],
                'value' => Str::slug($item['value']),
            ]);
        }
    }
}
