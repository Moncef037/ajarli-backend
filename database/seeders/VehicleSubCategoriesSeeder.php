<?php

namespace Database\Seeders;

use App\Models\VehicleSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category_id' => 1, 'label' => 'Micro pelle', 'value' => 'micro_pelle', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/micro_pelle.png'],
            ['category_id' => 1, 'label' => 'Mini Pelle sur chenilles', 'value' => 'mini_pelle_sur_chenilles', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/mini_pelle_sur_chenilles.png'],
            ['category_id' => 1, 'label' => 'Mini Pelle sur pneus', 'value' => 'mini_pelle_sur_pneus', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/mini_pelle_sur_pneus.png'],
            ['category_id' => 1, 'label' => 'Pelleteuse', 'value' => 'pelleteuse', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/pelleteuse.png'],
            ['category_id' => 1, 'label' => 'Pelleteuse sur pneus', 'value' => 'pelleteuse_sur_pneus', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/pelleteuse_sur_pneus.png'],
            ['category_id' => 1, 'label' => 'Pelleteuse à longue portée', 'value' => 'pelleteuse_a_longue_portee', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/pelleteuse_a_longue_portee.png'],
            ['category_id' => 1, 'label' => 'Mini chargeur', 'value' => 'mini_chargeur', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/mini_chargeur.png'],
            ['category_id' => 1, 'label' => 'Grand chargeur', 'value' => 'grand_chargeur', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/grand_chargeur.png'],
            ['category_id' => 1, 'label' => 'Mini retro chargeur', 'value' => 'mini_retro_chargeur', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/mini_retro_chargeur.png'],
            ['category_id' => 1, 'label' => 'Standard retro chargeur', 'value' => 'standard_retro_chargeur', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/standard_retro_chargeur.png'],
            ['category_id' => 1, 'label' => 'Bulldozer', 'value' => 'bulldozer', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/bulldozer.png'],
            ['category_id' => 1, 'label' => 'Pelleteuse minière', 'value' => 'pelleteuse_miniere', 'photo' => 'public/ajrli_machines/vehicles/machine_de_terrassement/pelleteuse_miniere.png'],

            ['category_id' => 2, 'label' => 'Decoupeuse', 'value' => 'decoupeuse', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/decoupeuse.png'],
            ['category_id' => 2, 'label' => 'Petit trancheuse à conducteur marchant', 'value' => 'petit_trancheuse_a_conducteur_marchant', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/petit_trancheuse_a_conducteur_marchant.png'],
            ['category_id' => 2, 'label' => 'Trancheuse à conducteur marchant', 'value' => 'trancheuse_a_conducteur_marchant', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/trancheuse_a_conducteur_marchant.png'],
            ['category_id' => 2, 'label' => 'Trancheuse à distance', 'value' => 'trancheuse_a_distance', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/trancheuse_a_distance.png'],
            ['category_id' => 2, 'label' => 'Mini Trancheuse', 'value' => 'mini_trancheuse', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/mini_trancheuse.png'],
            ['category_id' => 2, 'label' => 'Mini machine de forage', 'value' => 'mini_machine_de_forage', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/mini_machine_de_forage.png'],
            ['category_id' => 2, 'label' => 'Grand machine de forage', 'value' => 'grand_machine_de_forage', 'photo' => 'public/ajrli_machines/vehicles/trancheuse_et_foreuse/grand_machine_de_forage.png'],

            ['category_id' => 3, 'label' => 'Grue sur camion de chargement', 'value' => 'grue_sur_camion_de_chargement', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_camion_de_chargement.png'],
            ['category_id' => 3, 'label' => 'Grue sur châssis de chargement', 'value' => 'grue_sur_chassis_de_chargement', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_chassis_de_chargement.png'],
            ['category_id' => 3, 'label' => 'Grue sur lourd de chargement', 'value' => 'grue_sur_lourd_de_chargement', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_lourd_de_chargement.png'],
            ['category_id' => 3, 'label' => 'Grue sur châssis lourd', 'value' => 'grue_sur_chassis_lourd', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_chassis_lourd.png'],
            ['category_id' => 3, 'label' => 'Grue sur pneus tout terrain', 'value' => 'grue_sur_penus_tout_terrain', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_penus_tout_terrain.png'],
            ['category_id' => 3, 'label' => 'Grue sur chenilles', 'value' => 'grue_sur_chenilles', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_sur_chenilles.png'],
            ['category_id' => 3, 'label' => 'Grue montée sur camion', 'value' => 'grue_montee_sur_camion', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_montee_sur_camion.png'],
            ['category_id' => 3, 'label' => 'Grue mobile hydraulique', 'value' => 'grue_mobile_hydraulique', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_mobile_hydraulique.png'],
            ['category_id' => 3, 'label' => 'Grue à tour', 'value' => 'grue_a_tour', 'photo' => 'public/ajrli_machines/vehicles/grue_et_sur_camion/grue_a_tour.png'],

            ['category_id' => 4, 'label' => 'Mini tombereau', 'value' => 'mini_tombereau', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/mini_tombereau.png'],
            ['category_id' => 4, 'label' => 'Camion à benne', 'value' => 'camion_a_benne', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/camion_a_benne.png'],
            ['category_id' => 4, 'label' => 'Camion à citerne', 'value' => 'camion_a_citerne', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/camion_a_citerne.png'],
            ['category_id' => 4, 'label' => 'Grand camion à citerne', 'value' => 'grand_camion_a_citerne', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/grand_camion_a_citerne.png'],
            ['category_id' => 4, 'label' => 'Lourd à benne 6x4', 'value' => 'lourd_a_benne_6x4', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/lourd_a_benne_6x4.png'],
            ['category_id' => 4, 'label' => 'Lourd à benne 8x4', 'value' => 'lourd_a_benne_8x4', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/lourd_a_benne_8x4.png'],
            ['category_id' => 4, 'label' => 'Semi-remorque benne', 'value' => 'semi_remorque_benne', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/semi_remorque_benne.png'],
            ['category_id' => 4, 'label' => 'Tombereau articulé', 'value' => 'tombereau_articule', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/tombereau_articule.png'],
            ['category_id' => 4, 'label' => 'Tombereau rigide', 'value' => 'tombereau_rigide', 'photo' => 'public/ajrli_machines/vehicles/camion_a_benne_et_citerne/tombereau_rigide.png'],

            ['category_id' => 5, 'label' => 'Pompe à béton stationnaire', 'value' => 'pompe_a_beton_stationnaire', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/pompe_a_beton_stationnaire.png'],
            ['category_id' => 5, 'label' => 'Pompe à béton stationnaire hydraulique', 'value' => 'pompe_a_beton_stationnaire_hydraulique', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/pompe_a_beton_stationnaire_hydraulique.png'],
            ['category_id' => 5, 'label' => 'Mini camion malaxeur', 'value' => 'mini_camion_malaxeur', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/mini_camion_malaxeur.png'],
            ['category_id' => 5, 'label' => 'Camion malaxeur', 'value' => 'camion_malaxeur', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/camion_malaxeur.png'],
            ['category_id' => 5, 'label' => 'Camion pompe à béton', 'value' => 'camion_pompe_a_beton', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/camion_pompe_a_beton.png'],
            ['category_id' => 5, 'label' => 'Centrale à béton', 'value' => 'centrale_a_beton', 'photo' => 'public/ajrli_machines/vehicles/machine_a_beton/centrale_a_beton.png'],
            
            ['category_id' => 6, 'label' => 'Fraiseuse', 'value' => 'fraiseuse', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/fraiseuse.png'],
            ['category_id' => 6, 'label' => 'Rouleau vibrant pied de mouton', 'value' => 'rouleau_vibrant_pied_de_mouton', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/rouleau_vibrant_pied_de_mouton.png'],
            ['category_id' => 6, 'label' => 'Pied de mouton avec nivellement', 'value' => 'pied_de_mouton_avec_nivellement', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/pied_de_mouton_avec_nivellement.png'],
            ['category_id' => 6, 'label' => 'Niveleuse', 'value' => 'niveleuse', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/niveleuse.png'],
            ['category_id' => 6, 'label' => 'Finisseur', 'value' => 'finisseur', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/finisseur.png'],
            ['category_id' => 6, 'label' => 'Compacteur MONOCYLINDRE', 'value' => 'compacteur_monocylindre', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/compacteur_monocylindre.png'],
            ['category_id' => 6, 'label' => 'Double rouleau compacteur', 'value' => 'double_rouleau_compacteur', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/double_rouleau_compacteur.png'],
            ['category_id' => 6, 'label' => 'Compacteur à pneus', 'value' => 'compacteur_a_pneus', 'photo' => 'public/ajrli_machines/vehicles/machine_routiere/compacteur_a_pneus.png'],

            ['category_id' => 7, 'label' => 'Nacelle à mât vertical', 'value' => 'nacelle_a_mat_vertical', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_a_mat_vertical.png'],
            ['category_id' => 7, 'label' => 'Nacelle à ciseau', 'value' => 'nacelle_a_ciseau', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_a_ciseau.png'],
            ['category_id' => 7, 'label' => 'Nacelle articulée', 'value' => 'nacelle_articulee', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_articulee.png'],
            ['category_id' => 7, 'label' => 'Nacelle à flèche télescopique', 'value' => 'nacelle_a_fleche_telescopique', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_a_fleche_telescopique.png'],
            ['category_id' => 7, 'label' => 'Nacelle araignée', 'value' => 'nacelle_araignee', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_araignee.png'],
            ['category_id' => 7, 'label' => 'Nacelle sur fourgon', 'value' => 'nacelle_sur_fourgon', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_sur_fourgon.png'],
            ['category_id' => 7, 'label' => 'Nacelle sur lourd', 'value' => 'nacelle_sur_lourd', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_sur_lourd.png'],
            ['category_id' => 7, 'label' => 'Nacelle sur camion', 'value' => 'nacelle_sur_camion', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/nacelle_sur_camion.png'],
            ['category_id' => 7, 'label' => 'Monte meuble sur camion', 'value' => 'monte_meuble_sur_camion', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/monte_meuble_sur_camion.png'],
            ['category_id' => 7, 'label' => 'Remorque monte meuble', 'value' => 'remorque_monte_meuble', 'photo' => 'public/ajrli_machines/vehicles/platforme_elevatrice/remorque_monte_meuble.png'],
            
            ['category_id' => 8, 'label' => 'Clark forklift', 'value' => 'clark_forlift', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/clark_forlift.png'],
            ['category_id' => 8, 'label' => 'Grand clark forklift', 'value' => 'grand_clark_forlift', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/grand_clark_forlift.png'],
            ['category_id' => 8, 'label' => 'Transpalette électrique', 'value' => 'transpalette_electrique', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/transpalette_electrique.png'],
            ['category_id' => 8, 'label' => 'Transpalette manuel', 'value' => 'transpalette_manuel', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/transpalette_manuel.png'],
            ['category_id' => 8, 'label' => 'Télescopique fixe', 'value' => 'telescopique_fixe', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/telescopique_fixe.png'],
            ['category_id' => 8, 'label' => 'Télescopique rotatif', 'value' => 'telescopique_rotatif', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/telescopique_rotatif.png'],
            ['category_id' => 8, 'label' => 'Chariot télescopique', 'value' => 'chariot_telescopique', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/chariot_telescopique.png'],
            ['category_id' => 8, 'label' => 'Manutentionnaire', 'value' => 'manutentionnaire', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/manutentionnaire.png'],
            ['category_id' => 8, 'label' => 'Gerbeur de conteneurs', 'value' => 'gerbeur_de_conteneurs', 'photo' => 'public/ajrli_machines/vehicles/telescopique_et_clark/gerbeur_de_conteneurs.png'],

            ['category_id' => 9, 'label' => 'Simple cabine +2 places', 'value' => 'simple_cabine_2_places', 'photo' => 'public/ajrli_machines/vehicles/service_transport/simple_cabine_2_places.png'],
            ['category_id' => 9, 'label' => 'Pick-up 4-5 places + cabine', 'value' => 'pick_up_4_5_places_cabine', 'photo' => 'public/ajrli_machines/vehicles/service_transport/pick_up_4_5_places_cabine.png'],
            ['category_id' => 9, 'label' => '4-5 Places + équipement léger', 'value' => '4_5_places_equipement_leger', 'photo' => 'public/ajrli_machines/vehicles/service_transport/4_5_places_equipement_leger.png'],
            ['category_id' => 9, 'label' => '7-8 Places équipement léger', 'value' => '7_8_places_equipement_leger', 'photo' => 'public/ajrli_machines/vehicles/service_transport/7_8_places_equipement_leger.png'],
            ['category_id' => 9, 'label' => '10-12 Places équipement léger', 'value' => '10_12_places_equipement_leger', 'photo' => 'public/ajrli_machines/vehicles/service_transport/10_12_places_equipement_leger.png'],
            ['category_id' => 9, 'label' => 'Fourgon 12+ places', 'value' => 'fourgon_12_places', 'photo' => 'public/ajrli_machines/vehicles/service_transport/fourgon_12_places.png'],
            ['category_id' => 9, 'label' => 'Camion 4-5 places + cabine', 'value' => 'camion_4_5_places_cabine', 'photo' => 'public/ajrli_machines/vehicles/service_transport/camion_4_5_places_cabine.png'],
            ['category_id' => 9, 'label' => 'Fourgon 5-6 places + cabine', 'value' => 'fourgon_5_6_places_cabine', 'photo' => 'public/ajrli_machines/vehicles/service_transport/fourgon_5_6_places_cabine.png'],
            ['category_id' => 9, 'label' => 'Camion dépannage ou transport machine', 'value' => 'camion_depannage_ou_transport_machine', 'photo' => 'public/ajrli_machines/vehicles/service_transport/camion_depannage_ou_transport_machine.png'],
            ['category_id' => 9, 'label' => 'Lourd dépannage ou transport machine', 'value' => 'lourd_depannage_ou_transport_machine', 'photo' => 'public/ajrli_machines/vehicles/service_transport/lourd_depannage_ou_transport_machine.png'],

            ['category_id' => 10, 'label' => 'Trencheuse', 'value' => 'trencheuse', 'photo' => 'public/ajrli_machines/vehicles/attachement/trencheuse.png'],
            ['category_id' => 10, 'label' => 'Marteau', 'value' => 'marteau', 'photo' => 'public/ajrli_machines/vehicles/attachement/marteau.png'],
            ['category_id' => 10, 'label' => 'Tarière', 'value' => 'tariere', 'photo' => 'public/ajrli_machines/vehicles/attachement/tariere.png'],
            ['category_id' => 10, 'label' => 'Petit godet 2 dents', 'value' => 'petit_godet_2_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/petit_godet_2_dents.png'],
            ['category_id' => 10, 'label' => 'Petit godet 3 dents', 'value' => 'petit_godet_3_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/petit_godet_3_dents.png'],
            ['category_id' => 10, 'label' => 'Petit godet 4 dents', 'value' => 'petit_godet_4_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/petit_godet_4_dents.png'],
            ['category_id' => 10, 'label' => 'Grand godet 5 dents', 'value' => 'grand_godet_5_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/grand_godet_5_dents.png'],
            ['category_id' => 10, 'label' => 'Grand godet 6 dents', 'value' => 'grand_godet_6_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/grand_godet_6_dents.png'],
            ['category_id' => 10, 'label' => 'Large godet sans dents', 'value' => 'large_godet_sans_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/large_godet_sans_dents.png'],
            ['category_id' => 10, 'label' => 'Large godet tamiseur', 'value' => 'large_godet_tamiseur', 'photo' => 'public/ajrli_machines/vehicles/attachement/large_godet_tamiseur.png'],
            ['category_id' => 10, 'label' => 'Godet tamiseur 5 dents', 'value' => 'godet_tamiseur_5_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/godet_tamiseur_5_dents.png'],
            ['category_id' => 10, 'label' => 'Grappin avec godet', 'value' => 'grappin_avec_godet', 'photo' => 'public/ajrli_machines/vehicles/attachement/grappin_avec_godet.png'],
            ['category_id' => 10, 'label' => 'Grappin avec dents', 'value' => 'grappin_avec_dents', 'photo' => 'public/ajrli_machines/vehicles/attachement/grappin_avec_dents.png'],
        ];

        foreach ($data as $item) {
            VehicleSubCategory::create([
                'category_id' => $item['category_id'],
                'label' => $item['label'],
                'value' => Str::slug($item['value']),
                'photo' => $item['photo'],
            ]);
        }
    }
}
