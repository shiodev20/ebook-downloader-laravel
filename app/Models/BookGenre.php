<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'book_id', 'genre_id'];
}
