<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Table extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'table_orders')->withTimestamps();
    }
}
