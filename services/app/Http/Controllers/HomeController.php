<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BookCollection;

class HomeController extends Controller
{
    public function index() {
        $categories = Category::all();
        if(request('selectedCategories') == '') {
            $books = Book::all();
        }
        else {
        $selectedCategories = explode(',', request('selectedCategories'));
        $books = Book::whereIn('category_id', $selectedCategories)->get();
        
        }
        
        
        return (new BookCollection($books))->additional([
            'categories' => new CategoryCollection($categories),
            
        ]);
    }
}
