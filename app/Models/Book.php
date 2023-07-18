<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'title',
        'slug',
        'description',
        'num_pages',
        'publish_date',
        'downloads',
        'rating',
        'cover_url',
        'publisher_id',
        'author_id'
    ];

    public function reviews(): HasMany {
        return $this->hasMany(Review::class, 'book_id', 'book');
    }

    public function publisher(): BelongsTo {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }

    public function author(): BelongsTo {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
    
    public function genres(): BelongsToMany {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    public function files(): BelongsToMany {
        return $this->belongsToMany(FileType::class, 'book_files');
    }

    public function bookFiles() {
        return $this->hasMany(BookFile::class, 'book_id', 'id');
    }

    public function collections(): BelongsToMany {
        return $this->belongsToMany(Collection::class, 'collections');
    }
   
}
