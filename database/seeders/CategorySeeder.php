<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            'work',
            'home',
            'health',
            'family',
            'school',
            'hobby',
            'sport',
            'food',
            'project',
            'religion',
            'finance',
            'other'
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
