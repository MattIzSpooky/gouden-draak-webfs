<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'dish_type_id',
    ];

    /**
     * @return HasOne
     */
    public function menuItem(): HasOne
    {
        return  $this->hasOne(MenuItem::class, 'dish_id');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DishType::class, 'dish_type_id');
    }
}
