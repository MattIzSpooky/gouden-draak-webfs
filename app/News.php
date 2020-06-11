<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $perPage = 4;

    protected $fillable = ['title', 'text'];
}
