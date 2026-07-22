<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminDaftarLayananDarat;
use App\Models\AdminDaftarPaketLayananDarat;

class AdminDaftarLayananDaratSeeder extends Seeder
{
    public function run(): void
    {
        $photo = AdminDaftarLayananDarat::updateOrCreate(
            ['slug' => 'photographer'],
            ['nama' => 'Photographer', 'is_active' => true, 'sort_order' => 1]
        );

        $video = AdminDaftarLayananDarat::updateOrCreate(
            ['slug' => 'videographer'],
            ['nama' => 'Videographer', 'is_active' => true, 'sort_order' => 2]
        );

        $items = [
            // Photographer
            [$photo->id, 'photo_basic',    'Photo Basic',    '2 Jam, 1 Photographer, 50+ edit foto, digital only', 1],
            [$photo->id, 'photo_standard', 'Photo Standard', '4 Jam, 1 Photographer, 100+ edit foto, digital only', 2],
            [$photo->id, 'photo_premium',  'Photo Premium',  '8 Jam, 2 Photographer, 200+ edit foto, digital + album', 3],

            // Videographer
            [$video->id, 'video_basic',    'Video Basic',    '2 Jam, 1 Videographer, highlight 1–3 menit', 1],
            [$video->id, 'video_standard', 'Video Standard', '4 Jam, 1 Videographer, highlight 3–7 menit', 2],
            [$video->id, 'video_premium',  'Video Premium',  '8 Jam, 2 Crew, highlight + full dokumentasi, optional drone', 3],
        ];

        foreach ($items as [$layananId, $kode, $nama, $desc, $sort]) {
            AdminDaftarPaketLayananDarat::updateOrCreate(
                ['layanan_id' => $layananId, 'kode' => $kode],
                ['nama' => $nama, 'deskripsi' => $desc, 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
