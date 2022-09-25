<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(){

        $book = Book::create($this->validateRequest());
        return redirect($book->path());
    }

    public function update(Book $model){

        $model->update($this->validateRequest());
        return redirect($model->path());
    }

    public function delete(Book $model){

        $model->delete();
        return redirect('/books');
    }


    public function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }
}
