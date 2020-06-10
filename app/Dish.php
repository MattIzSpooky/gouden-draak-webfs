<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

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
        return $this->hasOne(MenuItem::class, 'dish_id');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DishType::class, 'dish_type_id');
    }

    /**
     * @return BelongsToMany
     */
    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(PromotionalDiscounts::class, 'promotional_discounts_dishes');
    }

    /**
     * @return Collection
     */
    public function hasDiscounts(): Collection
    {
        return $this->belongsToMany(PromotionalDiscounts::class, 'promotional_discounts_dishes')
            ->whereDate('valid_till', '>=', now())
            ->whereDate('valid_from', '<=', now())
            ->get();
    }

    /**
     * Determine that a dish has a discount
     *
     * @return boolean
     */
    public function validDiscounts(): bool
    {
        return $this->hasDiscounts()->count() > 0;
    }

    /**
     * Get the actual price of a dish
     *
     * @return void
     */
    public function actualPrice()
    {
        return !$this->validDiscounts()
            ? $this->attributes['price']
            : $this->discounts()->pluck('price')->first();
    }
}
