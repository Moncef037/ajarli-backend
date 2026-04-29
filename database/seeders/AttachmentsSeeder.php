<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $attachmentsData = [
            [
                'sub_category_id' => 93, 
                'brand' => 'Brand A', 
                'model' => 'Model A', 
                'year' => 2020, 
                'price_per_day' => 8000, 
                'price_per_month' => 80000, 
                'offer_type' => 'fixed', 
                'transport_price' => 3500, 
                'region' => 'Region A', 
                'city' => 'City A', 
                'phone_number' => '0555555555',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 10,
                'photos' => [
                    'public/attachments/photos/photo-0.jpg',
                    'public/attachments/photos/photo-1.jpg',
                ],
                'documents' => [
                    'public/attachments/documents/doc-0.pdf',
                ],
            ],
            [
                'sub_category_id' => 92, 
                'brand' => 'Brand B', 
                'model' => 'Model B', 
                'year' => 2019, 
                'price_per_day' => 7000, 
                'price_per_month' => 70000, 
                'offer_type' => 'fixed', 
                'transport_price' => 3000, 
                'region' => 'Region B', 
                'city' => 'City B', 
                'phone_number' => '0666666666',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 2,
                'photos' => [
                    'public/attachments/photos/photo-2.jpg',
                    'public/attachments/photos/photo-3.jpg',
                ],
                'documents' => [
                    'public/attachments/documents/doc-1.pdf',
                ],
            ],
            [
                'sub_category_id' => 89, 
                'brand' => 'Brand C', 
                'model' => 'Model C', 
                'year' => 2021, 
                'price_per_day' => 9000, 
                'price_per_month' => 90000, 
                'offer_type' => 'fixed', 
                'transport_price' => 4000, 
                'region' => 'Region C', 
                'city' => 'City C', 
                'phone_number' => '0777777777',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 9,
                'photos' => [
                    'public/attachments/photos/photo-4.jpg',
                    'public/attachments/photos/photo-5.jpg',
                ],
                'documents' => [
                    'public/attachments/documents/doc-2.pdf',
                ],
            ],
            [
                'sub_category_id' => 91, 
                'brand' => 'Brand D', 
                'model' => 'Model D', 
                'year' => 2018, 
                'price_per_day' => 6000, 
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
                    'public/attachments/photos/photo-6.jpg',
                    'public/attachments/photos/photo-7.jpg',
                ],
                'documents' => [
                    'public/attachments/documents/doc-3.pdf',
                ],
            ],
            [
                'sub_category_id' => 90, 
                'brand' => 'Brand E', 
                'model' => 'Model E', 
                'year' => 2022, 
                'price_per_day' => 10000, 
                'price_per_month' => 100000, 
                'offer_type' => 'negotiable', 
                'transport_price' => 4500, 
                'region' => 'Region E', 
                'city' => 'City E', 
                'phone_number' => '0999999999',
                'activity_status' => 'active',
                'approval_status' => 'not_approved',
                'user_id' => 9,
                'photos' => [
                    'public/attachments/photos/photo-8.jpg',
                    'public/attachments/photos/photo-9.jpg',
                ],
                'documents' => [
                    'public/attachments/documents/doc-4.pdf',
                ],
            ]
        ];

        foreach ($attachmentsData as $attachmentData) {
            $attachment = Attachment::create([
                'sub_category_id' => $attachmentData['sub_category_id'],
                'brand' => $attachmentData['brand'],
                'model' => $attachmentData['model'],
                'year' => $attachmentData['year'],
                'price_per_day' => $attachmentData['price_per_day'],
                'price_per_month' => $attachmentData['price_per_month'],
                'offer_type' => $attachmentData['offer_type'],
                'transport_price' => $attachmentData['transport_price'],
                'region' => $attachmentData['region'],
                'city' => $attachmentData['city'],
                'phone_number' => $attachmentData['phone_number'],
                'activity_status' => $attachmentData['activity_status'],
                'approval_status' => $attachmentData['approval_status'],
                'user_id' => $attachmentData['user_id'],
            ]);

            foreach ((array) $attachmentData['photos'] as $photo) {
                $attachment->photos()->create(['path' => $photo]);
            }

            foreach ((array) $attachmentData['documents'] as $document) {
                $attachment->documents()->create(['path' => $document]);
            }
        }
    }
}
