<?php

namespace App\Repository\IRepository;

interface IBookRepository extends IRepository {

  function find($expressions = []);

  function sort($flag);
}