<?php

namespace Tests\Feature;

 use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());
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
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id,[
            'title' => 'New Title',
            'author' => 'Victor'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('Victor', Book::first()->author);
    }
}
