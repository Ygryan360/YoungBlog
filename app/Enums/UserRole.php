<?php

namespace App\Enums;

enum UserRole: string
{
  case Superadmin = 'superadmin';
  case Admin = 'admin';
  case Author = 'author';
  case User = 'user';

  public function label(): string
  {
    return match ($this) {
      self::Superadmin => 'Superadmin',
      self::Admin => 'Admin',
      self::Author => 'Author',
      self::User => 'User',
    };
  }
}
