<?php

namespace App\Http\Controllers;

use App\Models\Rentlogs;
use Illuminate\Http\Request;

class RenLogController extends Controller
{
    public function index()
    {
        $rentlogs = Rentlogs::with(['user', 'book'])->get();
        return view('rentlog', ['rent_logs' => $rentlogs]);
    }
}
