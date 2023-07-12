<?php

namespace App\Repository\IRepository;

interface IRepository {

  function getAll();

  function getById($id);

  function add($attributes = []);

  function update($entity, $attributes = []);

  function delete($entity);

}