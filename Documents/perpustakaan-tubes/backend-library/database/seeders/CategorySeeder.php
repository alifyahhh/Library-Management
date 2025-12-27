<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Technology', 'description' => 'Programming, software, and IT'],
            ['name' => 'Business', 'description' => 'Management, finance, entrepreneurship'],
            ['name' => 'Novel', 'description' => 'Fiction and literature'],
            ['name' => 'Education', 'description' => 'Learning resources and textbooks'],
        ];

        foreach ($data as $row) {
            Category::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
