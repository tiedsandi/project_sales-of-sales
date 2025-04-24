<?php

namespace App\Helpers;

class RoleHelper
{
  public static function currentRole()
  {
    return session('selected_role');
  }

  public static function is($role)
  {
    return self::currentRole() === $role;
  }

  public static function isAny(array $roles)
  {
    return in_array(self::currentRole(), $roles);
  }
}
