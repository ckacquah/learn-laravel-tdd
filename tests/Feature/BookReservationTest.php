<?php

namespace Tests\Feature;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that model created from post request
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Victor',
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }


    /**
     * Test that title is required when creating model
     *
     * @return void
     */
    public function test_the_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors('title');
    }


    /**
     * Test that author is required when creating model
     *
     * @return void
     */
    public function test_the_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }


    /**
     * Test that an author can be updated
     *
     * @return void
     */
    public function test_a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $response->assertOk();
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}