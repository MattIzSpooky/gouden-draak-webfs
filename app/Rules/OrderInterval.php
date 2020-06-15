<?php

namespace App\Rules;

use App\Table;
use Illuminate\Contracts\Validation\Rule;

class OrderInterval implements Rule
{
    private $table;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table)
    {
        $this->table = Table::find($table);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $order = $this->table->orders()->latest()->first();

        if ($order) {
            $time = now()->diffInSeconds($order->created_at);

            if ($time < 600) {
                return false;
            }

            return true;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You should wait 10 minutes to take a second order!';
    }
}
