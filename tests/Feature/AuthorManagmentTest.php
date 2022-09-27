<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors',[
           'name' => 'Author Name',
            'dob' => '05/14/1000',
        ]);
        $author = Author::all();
        $this->assertCount(1,$author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('05/14/1000',$author->first()->dob->format('m/d/Y'));
    }
}
