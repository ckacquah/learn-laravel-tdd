<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [
        "created_at",
        "updated_at",
    ];

    protected $fillable = [
        "name",
        "date_of_birth",
    ];

    protected $dates = [
        "date_of_birth",
    ];

    public function setDateOfBirthAttribute($date_of_birth)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $date_of_birth);
    }

    public function path()
    {
        return '/authors/' . $this->id . '/' . Str::slug($this->created_at);
    }
}