<?php

namespace App;

use App\PromotionalDiscounts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Determine if this dish has a discount
     * 
     * @return bool
     */
    public function hasDiscount(): bool
    {
        return $this->discounts->count() > 0;
    }

    public function activeDiscount(): Collection
    {
        return $this->discounts()
            ->whereDate('valid_till', '>=', now())
            ->whereDate('valid_from', '<=', now())
            ->orderBy(DB::raw('ABS(DATEDIFF(promotional_discounts.valid_from, NOW()))'))
            ->get();
    }
}
