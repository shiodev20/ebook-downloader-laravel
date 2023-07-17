<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookFile extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'book_id',
        'file_type_id',
        'file_url'
    ];
}
