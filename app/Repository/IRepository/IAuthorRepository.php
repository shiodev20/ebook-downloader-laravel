<?php

namespace App\Repository\IRepository;

interface IAuthorRepository extends IRepository {

  function find($expressions = []);

  function sort($flag);

  function deleteBook($author, $book);

}