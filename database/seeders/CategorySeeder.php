<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
        'Website Development',
        'Website Design',
        'Fieldma',
        'TINT',
        'B2B E-commerce',
        'Bpainter',
        'SSM',
        'Branding',
        'Graphic Design',
        'Package Labeling',
];


        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(['name' => $category]);
        }
    }
}
