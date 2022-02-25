<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals(Reservation::first()->user_id, $user->id);
        $this->assertEquals(Reservation::first()->book_id, $book->id);
        $this->assertNotNull(Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    public function test_only_signed_user_can_checkout_a_book()
    {
        $book = Book::factory()->create();

        $this->post('/checkout/' . $book->id)
            ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    public function test_a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/' . $book->id);
        $this->actingAs($user)
            ->post('/checkin/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals(Reservation::first()->user_id, $user->id);
        $this->assertEquals(Reservation::first()->book_id, $book->id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    public function test_only_signed_user_can_checkin_a_book()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        Auth::logout();

        $this->post('/checkin/' . $book->id)
            ->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
    }

    public function test_if_not_checked_out_a_404_error_is_shown()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkin/' . $book->id)
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

    // public function test_a_user_can_checkout_a_book_twice()
    // {

    // }
}