<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'addition', 'dish_id', 'menu_number'
    ];

    /**
     * @return BelongsTo
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
