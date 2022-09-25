<?php

namespace Tests\Feature;

 use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Tests\TestCase;

class BookManagmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response->assertRedirect($book->path());
    }

    public function test_title_is_required()
    {

        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Victor'
        ]);
        $response->assertSessionHasErrors('title');
    }

    public function test_author_is_required()
    {

        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    public function test_book_can_be_updated()
    {

        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(),[
            'title' => 'New Title',
            'author' => 'Victor'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('Victor', Book::first()->author);
        $response->assertRedirect($book->path());
    }

    public function test_book_can_be_deleted()
    {

        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }
}
