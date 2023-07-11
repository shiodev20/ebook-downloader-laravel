<?php

namespace App\Repository;

interface IRepository {

  function getAll();

  function getById($id);

  function find($expressions = []);

  function add($attributes = []);

  function update($entity, $attributes = []);

  function delete($entity);

}