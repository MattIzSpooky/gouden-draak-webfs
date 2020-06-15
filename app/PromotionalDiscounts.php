<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PromotionalDiscounts extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'text', 'valid_from', 'valid_till', 'price'];

    protected $dates = ['valid_from', 'valid_till'];

    /**
     * @return BelongsToMany
     */
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'promotional_discounts_dishes');
    }

    public function scopeActive($query)
    {
        return $query
            ->whereDate('valid_till', '>=', now())
            ->whereDate('valid_from', '<=', now());
    }

    public function scopeActiveAndNextWeek($query)
    {
        return $query
            ->whereBetween('valid_from', [now()->subDay(), now()->addDays(8)]);
    }
}
