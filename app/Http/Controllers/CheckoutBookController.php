<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class CheckoutBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Book $book)
    {
        $book->checkout(Auth::user());
    }

    public function checkin(Book $book)
    {
        try {
            $book->checkin(Auth::user());
        } catch (\Exception$e) {
            return response([], 404);
        }
    }
}