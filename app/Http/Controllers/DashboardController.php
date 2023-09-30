<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount = book::count();
        $categoryCount = Category::count();
        $userCount = User::count();
        return view('dashboard', ['book_count' => $bookCount, 'category_count' => $categoryCount, 'user_count' => $userCount]);
    }
}
