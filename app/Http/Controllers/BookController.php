<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = book::all();
        return view('book', ['books' => $books]);
    }
    public function add()
    {
        $categories = Category::all();
        return view('book-add', ['categories' => $categories]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title' => 'required|max:255'
        ]);


        $newName = '';
        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'-'.$extension;
            $request->file('image')->storeAs('cover', $newName);
        }

        $request['cover'] = $newName;
        $book = book::create($request->all());
        $book->categories()->sync($request->categories);
        return redirect('books')->with('status', 'Book Added Successfully');
    }
    public function edit($slug)
    {
        $book = book::where('slug', $slug)->first();
        $categories = Category::all();
        return view('book-edit', ['categories' => $categories, 'book' => $book]);
    }
    public function update(Request $request, $slug)
    {
        
        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'-'.$extension;
            $request->file('image')->storeAs('cover', $newName);
            $request['cover'] = $newName;
        }

        $book = book::where('slug', $slug)->first();
        $book->update($request->all());

        if($request->categories) {
            $book->categories()->sync($request->categories);
            
    }   
    return redirect('books')->with('status', 'Book Updated Successfully');
}
public function delete($slug)
{
    $book = book::where('slug', $slug)->first();
    return view('book-delete', ['book' => $book]);
}
public function destroy($slug)
{
    $book = book::where('slug', $slug)->first();
        $book->delete();
        return redirect('books')->with('status', 'Book Deleted Successfully');
}
public function deletedBook()
    {
        $deteletdBooks = book::onlyTrashed()->get();
        return view('book-deleted-list', ['deletedBooks' => $deteletdBooks]);
    }
    public function restore($slug)
    {
        $book = book::withTrashed()->where('slug', $slug)->first();
        $book->restore();
        return redirect('books')->with('status', 'Book Restored Successfully');
        
    }
}
