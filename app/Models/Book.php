<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [
        "created_at",
        "updated_at",
    ];

    protected $fillable = [
        "author_id",
        "title",
    ];

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $author,
        ])->id;
    }

    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin($user)
    {
        $reservation = $this->reservations()
            ->where('user_id', '=', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (is_null($reservation)) {
            throw new Exception("Book has not been checkup by the user");
        }

        $reservation
            ->update([
                'checked_in_at' => now(),
            ]);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function path()
    {
        return '/books/' . $this->id . '/' . Str::slug($this->created_at) . '/' . Str::slug($this->title);
    }
}
