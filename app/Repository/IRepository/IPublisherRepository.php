<?php

namespace App\Repository\IRepository;

interface IPublisherRepository extends IRepository {

  function find($expressions = []);

  function sort($flag);

  function deleteBook($publisher, $book);

}