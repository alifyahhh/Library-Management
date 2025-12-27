<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $tech = Category::where('name', 'Technology')->first();
        $biz  = Category::where('name', 'Business')->first();
        $nov  = Category::where('name', 'Novel')->first();
        $edu  = Category::where('name', 'Education')->first();

        $books = [
            [
                'category_id' => $tech?->id,
                'isbn' => '978-1492056355',
                'title' => 'Learning Laravel',
                'author' => 'Some Author',
                'publisher' => 'Demo Publisher',
                'publication_year' => 2022,
                'stock' => 5,
                'description' => 'Laravel fundamentals for beginners.',
            ],
            [
                'category_id' => $tech?->id,
                'isbn' => '978-0134685991',
                'title' => 'Effective JavaScript',
                'author' => 'David Herman',
                'publisher' => 'Addison-Wesley',
                'publication_year' => 2019,
                'stock' => 3,
                'description' => 'Best practices in JavaScript.',
            ],
            [
                'category_id' => $biz?->id,
                'isbn' => '978-0062316110',
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'publisher' => 'Crown Business',
                'publication_year' => 2017,
                'stock' => 4,
                'description' => 'Innovation methodology for startups.',
            ],
            [
                'category_id' => $nov?->id,
                'isbn' => '978-0007525492',
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'publisher' => 'HarperCollins',
                'publication_year' => 2012,
                'stock' => 2,
                'description' => 'Classic fantasy novel.',
            ],
            [
                'category_id' => $edu?->id,
                'isbn' => '978-0321573513',
                'title' => 'Database Systems',
                'author' => 'Ramakrishnan',
                'publisher' => 'McGraw-Hill',
                'publication_year' => 2018,
                'stock' => 6,
                'description' => 'Introductory database textbook.',
            ],
        ];

        foreach ($books as $b) {
            if (!$b['category_id']) continue; // safety kalau kategori belum ada

            Book::updateOrCreate(
                ['isbn' => $b['isbn']],
                $b
            );
        }
    }
}
