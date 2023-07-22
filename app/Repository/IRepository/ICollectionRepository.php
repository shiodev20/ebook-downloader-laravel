<?php

namespace App\Repository\IRepository;

interface ICollectionRepository extends IRepository {

  function find($expressions = []);

  function sort($flag);

  function deleteBook($collection, $book);
}