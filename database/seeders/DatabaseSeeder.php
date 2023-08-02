<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Book;
use App\Models\FileType;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    $seedData = Storage::disk('local')->get('seed/data.json');
    $seedDataDecode = json_decode($seedData);

    $roles = $seedDataDecode->roles;
    foreach ($roles as $role) {
      Role::create([
        'id' => $role->id,
        'name' => $role->name
      ]);
    }

    $users = $seedDataDecode->users;
    foreach ($users as $user) {
      User::create([
        'id' => $user->id,
        'username' => $user->username,
        'email' => $user->email,
        'password' => $user->password,
        'status' => $user->status,
        'role_id' => $user->role_id,
        'created_at' => $user->createdAt,
        'created_at' => $user->createdAt,
      ]);
    }

    $genres = $seedDataDecode->genres;
    foreach ($genres as $genre) {
      Genre::create([
        'id' => $genre->id,
        'name' => $genre->name,
        'slug' => $genre->slug
      ]);
    }

    $authors = $seedDataDecode->authors;
    foreach ($authors as $author) {
      Author::create([
        'id' => $author->id,
        'name' => $author->name,
        'slug' => $author->slug
      ]);
    }

    $publishers = $seedDataDecode->publishers;
    foreach ($publishers as $publisher) {
      Publisher::create([
        'id' => $publisher->id,
        'name' => $publisher->name,
        'slug' => $publisher->slug
      ]);
    }


    $fileTypes = $seedDataDecode->fileTypes;
    foreach ($fileTypes as $fileType) {
      FileType::create([
        'id' => $fileType->id,
        'name' => $fileType->name,
        'color' => $fileType->color,
      ]);
    }

    $books = $seedDataDecode->books;
    foreach ($books as $book) {
      Book::create([
        'id' => $book->id,
        'title' => $book->title,
        'slug' => $book->slug,
        'cover_url' => $book->cover_url
      ]);
    }
  }
}
