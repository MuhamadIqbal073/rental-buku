<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->category || $request->title) {
            $books = book::where('title', 'like', '%'.$request->title.'%')
                    ->WhereHas('categories', function($q) use($request) {
                        $q->where('categories.id', $request->category);
                    })
                    ->get();
        }
        else {
            $books = book::all();
        }

        return view('book-list', ['books' => $books, 'categories' => $categories]);
    }
}
