<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Book extends Model
{
    use HasFactory;

    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];

    protected $fillable = [
        "author",
        "title",
    ];

    public function path()
    {
        return '/books/' . $this->id . '/' . Str::slug($this->created_at) . '/' . Str::slug($this->title);
    }
}