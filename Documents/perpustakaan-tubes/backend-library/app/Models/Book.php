<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id','isbn','title','author','publisher','publication_year',
        'stock','description','cover_image'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function borrowings() {
        return $this->hasMany(Borrowing::class);
    }
}
