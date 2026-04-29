<?php

namespace Database\Seeders;

use App\Models\EquipmentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['label' => 'Coffrage en bois et métallique', 'value' => 'coffrage_en_bois_et_metallique'],
            ['label' => 'Équipment de concret', 'value' => 'equipment_de_concret'],
            ['label' => 'Générateur et éclairage', 'value' => 'generateur_et_eclairage'],
            ['label' => 'Compactage et démolition', 'value' => 'compactage_et_demolition'],
            ['label' => 'Outil de fibre optique', 'value' => 'outil_de_fibre_optique'],
            ['label' => 'Soudage et coupage', 'value' => 'soudage_et_coupage'],
            ['label' => 'Platforme aérienne', 'value' => 'platforme_aerienne'],
        ];

        foreach ($data as $item) {
            EquipmentCategory::create([
                'label' => $item['label'],
                'value' => Str::slug($item['value']),
            ]);
        }
    }
}
