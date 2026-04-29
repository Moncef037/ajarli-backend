<?php

namespace Database\Seeders;

use App\Models\EquipmentSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category_id' => 1, 'label' => 'Coffrage en bois poteaux', 'value' => 'coffrage_en_bois_poteaux', 'photo' => 'public/ajrli_machines/equipments/coffrage_en_bois_et_metallique/coffrage_en_bois_poteaux.png'],
            ['category_id' => 1, 'label' => 'Bois de coffrage', 'value' => 'bois_de_coffrage', 'photo' => 'public/ajrli_machines/equipments/coffrage_en_bois_et_metallique/bois_de_coffrage.png'],
            ['category_id' => 1, 'label' => 'Coffrage métallique poteaux', 'value' => 'coffrage_metallique_poteaux', 'photo' => 'public/ajrli_machines/equipments/coffrage_en_bois_et_metallique/coffrage_metallique_poteaux.png'],
            ['category_id' => 1, 'label' => 'Coffrage modulaire pour voile', 'value' => 'coffrage_modulaire_pour_voile', 'photo' => 'public/ajrli_machines/equipments/coffrage_en_bois_et_metallique/coffrage_modulaire_pour_voile.png'],
            ['category_id' => 1, 'label' => 'Étayage réglable', 'value' => 'etayage_reglable', 'photo' => 'public/ajrli_machines/equipments/coffrage_en_bois_et_metallique/etayage_reglable.png'],
                        
            ['category_id' => 2, 'label' => 'Monte charge', 'value' => 'monte_charge', 'photo' => 'public/ajrli_machines/equipments/equipment_de_concret/monte_charge.png'],
            ['category_id' => 2, 'label' => 'Mini mixeur concerté', 'value' => 'mini_mixeur_concerte', 'photo' => 'public/ajrli_machines/equipments/equipment_de_concret/mini_mixeur_concerte.png'],
            ['category_id' => 2, 'label' => 'Truelle mécanique', 'value' => 'truelle_mecanique', 'photo' => 'public/ajrli_machines/equipments/equipment_de_concret/truelle_mecanique.png'],
            ['category_id' => 2, 'label' => 'Vibrateur de béton', 'value' => 'vibrateur_de_beton', 'photo' => 'public/ajrli_machines/equipments/equipment_de_concret/vibrateur_de_beton.png'],

            ['category_id' => 3, 'label' => 'Mini groupe électrogène', 'value' => 'mini_groupe_electrogene', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/mini_groupe_electrogene.png'],
            ['category_id' => 3, 'label' => 'Alimentation portable par batterie', 'value' => 'alimentation_portable_par_batterie', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/alimentation_portable_par_batterie.png'],
            ['category_id' => 3, 'label' => 'Générateur sur remorque', 'value' => 'generateur_sur_remorque', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/generateur_sur_remorque.png'],
            ['category_id' => 3, 'label' => 'Grand fixe groupe électrogène', 'value' => 'grand_fixe_groupe_electrogene', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/grand_fixe_groupe_electrogene.png'],
            ['category_id' => 3, 'label' => 'Compresseur à air', 'value' => 'compresseur_a_air', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/compresseur_a_air.png'],
            ['category_id' => 3, 'label' => 'Pompe à eau', 'value' => 'pompe_a_eau', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/pompe_a_eau.png'],
            ['category_id' => 3, 'label' => 'Lampe de travail portative', 'value' => 'lampe_de_travail_portative', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/lampe_de_travail_portative.png'],
            ['category_id' => 3, 'label' => "Tour d'éclairage de chantier", 'value' => 'tour_d_eclairage_de_chantier', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/tour_d_eclairage_de_chantier.png'],
            ['category_id' => 3, 'label' => 'Panneau de signalisation remorque', 'value' => 'panneau_de_signalisation_remorque', 'photo' => 'public/ajrli_machines/equipments/generateur_et_eclairage/panneau_de_signalisation_remorque.png'],
            
            ['category_id' => 4, 'label' => 'Marteau piqueur', 'value' => 'marteau_piqueur', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/marteau_piqueur.png'],
            ['category_id' => 4, 'label' => 'Compacteur à plaque', 'value' => 'compacteur_a_plaque', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/compacteur_a_plaque.png'],
            ['category_id' => 4, 'label' => 'Pilonneuse compacteur', 'value' => 'pilonneuse_compacteur', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/pilonneuse_compacteur.png'],
            ['category_id' => 4, 'label' => 'Marteau perforateur', 'value' => 'marteau_perforateur', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/marteau_perforateur.png'],
            ['category_id' => 4, 'label' => 'Perceuse', 'value' => 'perceuse', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/perceuse.png'],
            ['category_id' => 4, 'label' => 'Rouleau compacteur', 'value' => 'rouleau_compacteur', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/rouleau_compacteur.png'],
            ['category_id' => 4, 'label' => 'Rouleau pied de mouton', 'value' => 'rouleau_pied_de_mouton', 'photo' => 'public/ajrli_machines/equipments/compactage_et_demolition/rouleau_pied_de_mouton.png'],

            ['category_id' => 5, 'label' => 'Soudeuse fibre optique', 'value' => 'soudeuse_fibre_optique', 'photo' => 'public/ajrli_machines/equipments/outil_de_fibre_optique/soudeuse_fibre_optique.png'],
            ['category_id' => 5, 'label' => 'OTDR', 'value' => 'otdr', 'photo' => 'public/ajrli_machines/equipments/outil_de_fibre_optique/otdr.png'],
            ['category_id' => 5, 'label' => 'Power meter fiber optic', 'value' => 'power_meter_fiber_optic', 'photo' => 'public/ajrli_machines/equipments/outil_de_fibre_optique/power_meter_fiber_optic.png'],
            ['category_id' => 5, 'label' => 'Laser fiber optic', 'value' => 'laser_fiber_optic', 'photo' => 'public/ajrli_machines/equipments/outil_de_fibre_optique/laser_fiber_optic.png'],
            ['category_id' => 5, 'label' => 'Dérouleuse de câble', 'value' => 'derouleuse_de_cable', 'photo' => 'public/ajrli_machines/equipments/outil_de_fibre_optique/derouleuse_de_cable.png'],
            
            ['category_id' => 6, 'label' => 'Coudeuse', 'value' => 'coudeuse', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/coudeuse.png'],
            ['category_id' => 6, 'label' => 'Cisaille électrique portable', 'value' => 'cisaille_electrique_portable', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/cisaille_electrique_portable.png'],
            ['category_id' => 6, 'label' => 'Mini cisaille électrique', 'value' => 'mini_cisaille_electrique', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/mini_cisaille_electrique.png'],
            ['category_id' => 6, 'label' => 'Mini machine de soudage', 'value' => 'mini_machine_de_soudage', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/mini_machine_de_soudage.png'],
            ['category_id' => 6, 'label' => 'Machine de soudage', 'value' => 'machine_de_soudage', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/machine_de_soudage.png'],
            ['category_id' => 6, 'label' => "Mini meuleuse d'angle", 'value' => 'mini_meuleuse_d_angle', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/mini_meuleuse_d_angle.png'],
            ['category_id' => 6, 'label' => "Meuleuse d'angle", 'value' => 'meuleuse_d_angle', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/meuleuse_d_angle.png'],
            ['category_id' => 6, 'label' => 'Scie à onglet', 'value' => 'scie_a_onglet', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/scie_a_onglet.png'],
            ['category_id' => 6, 'label' => 'Scie circulaire', 'value' => 'scie_circulaire', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/scie_circulaire.png'],
            ['category_id' => 6, 'label' => 'Tronçonneuse à essence', 'value' => 'tronconneuse_a_essence', 'photo' => 'public/ajrli_machines/equipments/soudage_et_coupage/tronconneuse_a_essence.png'],

            ['category_id' => 7, 'label' => 'Échelle', 'value' => 'echelle', 'photo' => 'public/ajrli_machines/equipments/platforme_aerienne/echelle.png'],
            ['category_id' => 7, 'label' => 'Échelle double', 'value' => 'echelle_double', 'photo' => 'public/ajrli_machines/equipments/platforme_aerienne/echelle_double.png'],
            ['category_id' => 7, 'label' => 'Échafaudage', 'value' => 'echafaudage', 'photo' => 'public/ajrli_machines/equipments/platforme_aerienne/echafaudage.png'],
        ];

        foreach ($data as $item) {
            EquipmentSubCategory::create([
                'category_id' => $item['category_id'],
                'label' => $item['label'],
                'value' => Str::slug($item['value']),
                'photo' => $item['photo'],
            ]);
        }
    }
}
