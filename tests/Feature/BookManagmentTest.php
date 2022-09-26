<?php

namespace Tests\Feature;

 use App\Models\Author;
 use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Tests\TestCase;

class BookManagmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response->assertRedirect($book->path());
    }

    public function test_title_is_required()
    {

        $response = $this->post('/books',array_merge($this->data(),['title' => '']));
        $response->assertSessionHasErrors('title');
    }

    public function test_author_is_required()
    {

        $response = $this->post('/books',array_merge($this->data(),['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

    public function test_book_can_be_updated()
    {

        $this->post('/books',$this->data());

        $book = Book::first();

        $response = $this->patch($book->path(),[
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(Author::all()->last()->id, Book::first()->author_id);
        $response->assertRedirect($book->path());
    }

    public function test_book_can_be_deleted()
    {

        $this->post('/books',$this->data());

        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }

    public function test_author_added_automatically_if_not_exists_when_creating_a_new_book()
    {
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author_id' => 'Victor'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertcount(1, $book->all());
        $this->assertEquals($author->id, $book->author_id);
    }


    public function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor'
        ];
    }
}
