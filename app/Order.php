<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $perPage = 20;

    protected $fillable = ['paid_at'];

    protected $dates = ['paid_at'];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'order_items', null, 'item_id')
            ->withPivot('amount');
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->attributes['is_paid'] !== null;
    }
}
