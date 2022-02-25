<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_book_can_be_checked_out()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals(Reservation::first()->user_id, $user->id);
        $this->assertEquals(Reservation::first()->book_id, $book->id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_book_can_be_checked_in()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkout($user);
        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals(Reservation::first()->user_id, $user->id);
        $this->assertEquals(Reservation::first()->book_id, $book->id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_checkout_a_book_twice()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals(Reservation::find(2)->user_id, $user->id);
        $this->assertEquals(Reservation::find(2)->book_id, $book->id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals(Reservation::find(2)->user_id, $user->id);
        $this->assertEquals(Reservation::find(2)->book_id, $book->id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(Exception::class);

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkin($user);

    }
}