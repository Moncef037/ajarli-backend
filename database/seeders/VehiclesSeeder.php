<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $vehiclesData = [
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
                'user_id' => 1,
                'photos' => [
                    'public/vehicles/photos/photo-0.jpg',
                    'public/vehicles/photos/photo-1.jpg',
                ],
                'documents' => [
                    'public/vehicles/documents/doc-0.pdf',
                ],
                'attachments' => [
                    [
                        'sub_category_id' => 3,
                        'price' => 2000,
                    ],
                    [
                        'sub_category_id' => 4,
                        'price' => 3000,
                    ],
                ]
            ],
            [
                'category_id' => 2, 
                'sub_category_id' => 17, 
                'brand' => 'Brand B', 
                'model' => 'Model B', 
                'year' => 2019, 
                'price_per_day' => 7000, 
                'price_per_month' => 70000, 
                'offer_type' => 'fixed', 
                'transport_price' => 3000, 
                'operator_price' => 2500, 
                'region' => 'Region B', 
                'city' => 'City B', 
                'phone_number' => '0666666666',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 2,
                'photos' => [
                    'public/vehicles/photos/photo-2.jpg',
                    'public/vehicles/photos/photo-3.jpg',
                ],
                'documents' => [
                    'public/vehicles/documents/doc-1.pdf',
                ],
                'attachments' => [
                    [
                        'sub_category_id' => 81,
                        'price' => 2500,
                    ],
                    [
                        'sub_category_id' => 82,
                        'price' => 3500,
                    ],
                ]
            ],
            [
                'category_id' => 3, 
                'sub_category_id' => 21, 
                'brand' => 'Brand C', 
                'model' => 'Model C', 
                'year' => 2021, 
                'price_per_day' => 9000, 
                'price_per_month' => 90000, 
                'offer_type' => 'fixed', 
                'transport_price' => 4000, 
                'operator_price' => 3500, 
                'region' => 'Region C', 
                'city' => 'City C', 
                'phone_number' => '0777777777',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 5,
                'photos' => [
                    'public/vehicles/photos/photo-4.jpg',
                    'public/vehicles/photos/photo-5.jpg',
                ],
                'documents' => [
                    'public/vehicles/documents/doc-2.pdf',
                ],
                'attachments' => [
                    [
                        'sub_category_id' => 83,
                        'price' => 3000,
                    ],
                    [
                        'sub_category_id' => 84,
                        'price' => 4000,
                    ],
                ]
            ],
            [
                'category_id' => 4, 
                'sub_category_id' => 35, 
                'brand' => 'Brand D', 
                'model' => 'Model D', 
                'year' => 2018, 
                'price_per_day' => 6000, 
                'price_per_month' => 60000, 
                'offer_type' => 'negotiable', 
                'transport_price' => 2500, 
                'operator_price' => 2000, 
                'region' => 'Region D', 
                'city' => 'City D', 
                'phone_number' => '0888888888',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 6,
                'photos' => [
                    'public/vehicles/photos/photo-6.jpg',
                    'public/vehicles/photos/photo-7.jpg',
                ],
                'documents' => [
                    'public/vehicles/documents/doc-3.pdf',
                ],
                'attachments' => [
                    [
                        'sub_category_id' => 85,
                        'price' => 1500,
                    ],
                    [
                        'sub_category_id' => 86,
                        'price' => 2500,
                    ],
                ]
            ],
            [
                'category_id' => 5, 
                'sub_category_id' => 40, 
                'brand' => 'Brand E', 
                'model' => 'Model E', 
                'year' => 2022, 
                'price_per_day' => 10000, 
                'price_per_month' => 100000, 
                'offer_type' => 'negotiable', 
                'transport_price' => 4500, 
                'operator_price' => 4000, 
                'region' => 'Region E', 
                'city' => 'City E', 
                'phone_number' => '0999999999',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 9,
                'photos' => [
                    'public/vehicles/photos/photo-8.jpg',
                    'public/vehicles/photos/photo-9.jpg',
                ],
                'documents' => [
                    'public/vehicles/documents/doc-4.pdf',
                ],
                'attachments' => [
                    [
                        'sub_category_id' => 87,
                        'price' => 5000,
                    ],
                    [
                        'sub_category_id' => 88,
                        'price' => 6000,
                    ],
                ]
            ]
        ];

        foreach ($vehiclesData as $vehicleData) {
            $vehicle = Vehicle::create([
                'category_id' => $vehicleData['category_id'],
                'sub_category_id' => $vehicleData['sub_category_id'],
                'brand' => $vehicleData['brand'],
                'model' => $vehicleData['model'],
                'year' => $vehicleData['year'],
                'price_per_day' => $vehicleData['price_per_day'],
                'price_per_month' => $vehicleData['price_per_month'],
                'offer_type' => $vehicleData['offer_type'],
                'transport_price' => $vehicleData['transport_price'],
                'operator_price' => $vehicleData['operator_price'],
                'region' => $vehicleData['region'],
                'city' => $vehicleData['city'],
                'phone_number' => $vehicleData['phone_number'],
                'activity_status' => $vehicleData['activity_status'],
                'approval_status' => $vehicleData['approval_status'],
                'user_id' => $vehicleData['user_id'],
            ]);

            foreach ($vehicleData['photos'] as $photo) {
                $vehicle->photos()->create(['path' => $photo]);
            }

            foreach ($vehicleData['documents'] as $document) {
                $vehicle->documents()->create(['path' => $document]);
            }

            if (isset($vehicleData['attachments'])) {
                foreach ($vehicleData['attachments'] as $attachment) {
                    $vehicle->attachments()->create($attachment);

                    Attachment::create([
                        'sub_category_id' => $attachment['sub_category_id'],
                        'activity_status' => 'active',
                        'approval_status' => 'not_approved',
                        'user_id' => $vehicleData['user_id'],
                    ]);
                }
            }
        }
    }
}
