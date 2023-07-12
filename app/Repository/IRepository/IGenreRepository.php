<?php

namespace App\Repository\IRepository;

interface IGenreRepository extends IRepository {

  function find($expressions = []);

  function sort($flag);
}