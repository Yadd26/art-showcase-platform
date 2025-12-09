<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fotografi',
                'description' => 'Karya seni fotografi dan editing foto',
                'icon' => '📷',
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Desain antarmuka pengguna dan pengalaman pengguna',
                'icon' => '🎨',
            ],
            [
                'name' => '3D Art',
                'description' => 'Karya seni 3 dimensi dan modeling',
                'icon' => '🎭',
            ],
            [
                'name' => 'Ilustrasi',
                'description' => 'Gambar ilustrasi dan digital painting',
                'icon' => '✏️',
            ],
            [
                'name' => 'Grafis Design',
                'description' => 'Desain grafis, poster, dan branding',
                'icon' => '🖼️',
            ],
            [
                'name' => 'Animation',
                'description' => 'Animasi 2D dan 3D',
                'icon' => '🎬',
            ],
            [
                'name' => 'Digital Art',
                'description' => 'Seni digital dan mixed media',
                'icon' => '💻',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}