<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function validateRequest()
    {
        return request()->validate([
            'title' => "required",
            'author_id' => "required",
        ]);
    }

    public function store()
    {
        $data = $this->validateRequest();
        $book = Book::create($this->validateRequest());
        return redirect($book->path());
    }

    public function update(Book $book)
    {
        $book->update($this->validateRequest());
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}