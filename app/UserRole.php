<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;

    public const ADMIN = 3;
    public const KASSA = 2;
    public const WAITRESS = 1;
}
