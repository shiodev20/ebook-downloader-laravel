<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FileType extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name'
    ];

    public function books(): BelongsToMany {
        return $this->belongsToMany(Book::class, 'book_files');
    }
}
