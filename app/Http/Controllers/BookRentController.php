<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Rentlogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = book::all();
        return view('book-rent', ['users' => $users, 'books' => $books]);
    }
    public function store(Request $request)
    {
        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();

        $book = book::findOrfail($request->book_id)->only('status');

        if ($book['status'] != 'in stock') {
            Session::flash('message', 'Cannot rent, the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }
        else { 
            $count = Rentlogs::where('user_id', $request->user_id)->where('actual_return_date', null)
            ->count();
            
            if($count >= 3) {
            Session::flash('message', 'Cannot rent, user has reach limit of book');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
            }
            else {
                try {
                    DB::beginTransaction();
        
                    Rentlogs::create($request->all());
        
                    $book = book::findOrFail($request->book_id);
                    $book->status = 'not available';
                    $book->save();
                    DB::commit();
        
                    Session::flash('message', 'Rent Book Success');
                    Session::flash('alert-class', 'alert-success');
                    return redirect('book-rent');
                    } catch (\Throwable $th) {
                        DB::rollBack();
                    }
                }
            }
        }

    public function returnBook()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = book::all();
        return view('return-book', ['users' => $users, 'books' => $books]);
    }
    public function saveReturnBook(Request $request)
    {
        $rent = Rentlogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date', null);
        $rentData = $rent->first();
        $countData = $rent->count();

        if($countData == 1) {
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();

            Session::flash('message', 'The Book is returned successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect('book-return');
        }
        else {
            Session::flash('message', 'There is error in process');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-return');
        }
    }
}
