<?php

namespace App\Enums;

enum RoleEnum:int {
  case MASTER_ADMIN = 1;
  case ADMIN = 2;
  case MEMBER = 3;
}