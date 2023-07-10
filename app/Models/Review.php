<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    public $incrementintg = false;
    protected $fillable = [
        'id',
        'content',
        'rate',
        'user_id',
        'book_id'
    ];

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
