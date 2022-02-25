<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_an_author_is_created()
    {
        $this->withoutExceptionHandling();

        $book = Book::create([
            'title' =>  'Cool book title',
            'author_id' => 'Victor',
        ]);

        $this->assertCount(1, Book::all());
        $this->assertEquals($book->author_id, Author::first()->id);
    }
}