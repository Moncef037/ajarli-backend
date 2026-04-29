<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $equipmentsData = [
            [
                'category_id' => 1, 
                'sub_category_id' => 1, 
                'brand' => 'Brand A', 
                'model' => 'Model A', 
                'year' => 2020, 
                'price_per_day' => 8000, 
                'price_per_month' => 80000, 
                'offer_type' => 'fixed', 
                'transport_price' => 3500,
                'operator_price' => 3000,
                'region' => 'Region A', 
                'city' => 'City A', 
                'phone_number' => '0555555555',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 10,
                'photos' => [
                    'public/equipments/photos/photo-0.jpg',
                    'public/equipments/photos/photo-1.jpg',
                ],
                'documents' => [
                    'public/equipments/documents/doc-0.pdf',
                ],
            ],
            [
                'category_id' => 2, 
                'sub_category_id' => 7, 
                'brand' => 'Brand B', 
                'model' => 'Model B', 
                'year' => 2019, 
                'price_per_day' => 7000, 
                'price_per_month' => 70000, 
                'offer_type' => 'fixed', 
                'operator_price' => 3000,
                'transport_price' => 3000, 
                'region' => 'Region B', 
                'city' => 'City B', 
                'phone_number' => '0666666666',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 2,
                'photos' => [
                    'public/equipments/photos/photo-2.jpg',
                    'public/equipments/photos/photo-3.jpg',
                ],
                'documents' => [
                    'public/equipments/documents/doc-1.pdf',
                ],
            ],
            [
                'category_id' => 3, 
                'sub_category_id' => 13, 
                'brand' => 'Brand C', 
                'model' => 'Model C', 
                'year' => 2021, 
                'price_per_day' => 9000, 
                'price_per_month' => 90000, 
                'offer_type' => 'fixed', 
                'operator_price' => 3000,
                'transport_price' => 4000, 
                'region' => 'Region C', 
                'city' => 'City C', 
                'phone_number' => '0777777777',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 9,
                'photos' => [
                    'public/equipments/photos/photo-4.jpg',
                    'public/equipments/photos/photo-5.jpg',
                ],
                'documents' => [
                    'public/equipments/documents/doc-2.pdf',
                ],
            ],
            [
                'category_id' => 4, 
                'sub_category_id' => 21, 
                'brand' => 'Brand D', 
                'model' => 'Model D', 
                'year' => 2018, 
                'price_per_day' => 6000, 
                'operator_price' => 3000,
                'price_per_month' => 60000, 
                'offer_type' => 'negotiable', 
                'transport_price' => 2500, 
                'region' => 'Region D', 
                'city' => 'City D', 
                'phone_number' => '0888888888',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 10,
                'photos' => [
                    'public/equipments/photos/photo-6.jpg',
                    'public/equipments/photos/photo-7.jpg',
                ],
                'documents' => [
                    'public/equipments/documents/doc-3.pdf',
                ],
            ],
            [
                'category_id' => 5, 
                'sub_category_id' => 30, 
                'brand' => 'Brand E', 
                'model' => 'Model E', 
                'year' => 2022, 
                'price_per_day' => 10000, 
                'price_per_month' => 100000, 
                'offer_type' => 'negotiable', 
                'operator_price' => 3000,
                'transport_price' => 4500, 
                'region' => 'Region E', 
                'city' => 'City E', 
                'phone_number' => '0999999999',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 9,
                'photos' => [
                    'public/equipments/photos/photo-8.jpg',
                    'public/equipments/photos/photo-9.jpg',
                ],
                'documents' => [
                    'public/equipments/documents/doc-4.pdf',
                ],
            ]
        ];

        foreach ($equipmentsData as $equipmentData) {
            $equipment = Equipment::create([
                'category_id' => $equipmentData['category_id'],
                'sub_category_id' => $equipmentData['sub_category_id'],
                'brand' => $equipmentData['brand'],
                'model' => $equipmentData['model'],
                'year' => $equipmentData['year'],
                'price_per_day' => $equipmentData['price_per_day'],
                'price_per_month' => $equipmentData['price_per_month'],
                'offer_type' => $equipmentData['offer_type'],
                'transport_price' => $equipmentData['transport_price'],
                'operator_price' => $equipmentData['operator_price'],
                'region' => $equipmentData['region'],
                'city' => $equipmentData['city'],
                'phone_number' => $equipmentData['phone_number'],
                'activity_status' => $equipmentData['activity_status'],
                'approval_status' => $equipmentData['approval_status'],
                'user_id' => $equipmentData['user_id'],
            ]);

            foreach ((array) $equipmentData['photos'] as $photo) {
                $equipment->photos()->create(['path' => $photo]);
            }

            foreach ((array) $equipmentData['documents'] as $document) {
                $equipment->documents()->create(['path' => $document]);
            }
        }
    }
}
