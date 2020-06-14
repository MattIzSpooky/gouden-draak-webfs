<?php

namespace App;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

class DailySummary extends Model
{
    public $timestamps = false;

    protected $perPage = 8;

    protected $fillable = ['date', 'file'];

    protected $dates = ['date'];
}