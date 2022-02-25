<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
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
        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /**
     * Test that title is required when creating model
     *
     * @return void
     */
    public function test_the_title_is_required()
    {
        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }

    /**
     * Test that author is required when creating model
     *
     * @return void
     */
    public function test_the_author_is_required()
    {
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

    /**
     * Test that an author can be updated
     *
     * @return void
     */
    public function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $first_author_id = $book;

        $response = $this->patch($book->path(), array_merge($this->data(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]));

        $this->assertEquals('New Title', $book->fresh()->title);
        $this->assertCount(2, Author::all());
        $this->assertNotEquals($book->author_id, $first_author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * Test that an author can be updated
     *
     * @return void
     */
    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor Valdes',
        ];
    }
}