<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCollection extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'book_id', 'collection_id'];
}
