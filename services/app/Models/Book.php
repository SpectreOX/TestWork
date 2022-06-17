<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'publish_date',
        'author_name',
        'category_id',
        'description',
        'isbn',
    ];
    public function category() {

        return $this->belongsTo('App\Models\Category');
    }
}
