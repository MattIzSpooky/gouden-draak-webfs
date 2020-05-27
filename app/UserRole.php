<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;

    public const CUSTOMER = 1;
    public const ADMIN = 2;
    public const KASSA = 3;
    public const WAITRESS = 4;
}
