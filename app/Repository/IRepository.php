<?php

namespace App\Repository;

interface IRepository {

  function getAll();

  function getById($id);

  function find($expressions = []);

  // function add($attributes = []);

  // function update($id, $attributes = []);

  // function delete($id);

}