<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_only_name_is_required()
    {
        Author::firstOrCreate($this->data());
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'name' => 'Victor Valdes',
        ];
    }
}