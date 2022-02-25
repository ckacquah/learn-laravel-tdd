<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that a new author can created from post request
     *
     * @return void
     */
    public function test_an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/authors', [
            'name' => 'Gregory Jordan',
            'date_of_birth' => '05/02/1992',
        ]);

        $this->assertCount(1, Author::all());

        $author = Author::first();
        $this->assertInstanceOf(Carbon::class, $author->date_of_birth);
        $this->assertEquals('1992/05/02', $author->date_of_birth->format('Y/d/m'));

        $author = Author::first();
        $response->assertRedirect($author->path());
    }


    /**
     * Test that a new author can created from post request
     *
     * @return void
     */
    public function test_a_new_author_is_automatically_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'author_id' => 'Gregory Jordan',
            'title' => 'Cool book title',
        ]);

        $author = Author::first();
        $book = Book::first();
        $this->assertEquals($book->author_id, $author->id);
        $this->assertCount(1, Author::all());
    }
}