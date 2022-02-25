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

    public function test_an_author_can_be_created()
    {
        $response = $this->post('/authors', $this->data());

        $this->assertCount(1, Author::all());

        $author = Author::first();
        $this->assertInstanceOf(Carbon::class, $author->date_of_birth);
        $this->assertEquals('1992/05/02', $author->date_of_birth->format('Y/d/m'));

        $author = Author::first();
        $response->assertRedirect($author->path());
    }

    public function test_a_new_author_is_automatically_created()
    {
        $response = $this->post('/books', [
            'author_id' => 'Gregory Jordan',
            'title' => 'Cool book title',
        ]);

        $author = Author::first();
        $book = Book::first();
        $this->assertEquals($book->author_id, $author->id);
        $this->assertCount(1, Author::all());
    }

    public function test_that_the_name_feild_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(),
            ['name' => '']));
        $response->assertSessionHasErrors('name');
    }

    private function data()
    {
        return [
            'name' => 'Gregory Jordan',
            'date_of_birth' => '05/02/1992',
        ];
    }
}