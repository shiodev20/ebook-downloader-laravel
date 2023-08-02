<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Diglactic\Breadcrumbs\Breadcrumbs;


Breadcrumbs::for('home', function ($trail) {
  $trail->push('Trang Chủ', route('client.home'));
});

Breadcrumbs::for('page', function ($trail, $model) {
  $trail->parent('home');

  if($model instanceof Genre) {
    $trail->push('Thể Loại');
    $trail->push($model->name, route('client.booksByGenre', ['slug' => $model->slug]));
  }

  if($model instanceof Author) {
    $trail->push('Tác Giả');
    $trail->push($model->name, route('client.booksByAuthor', ['slug' => $model->slug]));
  }

  if($model instanceof Publisher) {
    $trail->push('Nhà Xuất Bản');
    $trail->push($model->name, route('client.booksByPublisher', ['slug' => $model->slug]));
  }

  if($model == 'sach-moi-nhat')  $trail->push('Sách Mới Nhất', route('client.booksByCollection', ['slug' => $model]));
  if($model == 'sach-hay-nen-doc')  $trail->push('Sách Hay Nên Đọc', route('client.booksByCollection', ['slug' => $model]));
  if($model == 'sach-tai-nhieu-nhat')  $trail->push('Sách Tải Nhiều Nhất', route('client.booksByCollection', ['slug' => $model]));
  if($model == 'tuyen-tap-hay')  $trail->push('Tuyển Tập Hay', route('client.booksByCollection', ['slug' => $model]));
});


Breadcrumbs::for('book', function ($trail, Book $book) {
  $trail->parent('home');
  $trail->push($book->title, route('client.detail', ['slug' => $book->slug]));
});

