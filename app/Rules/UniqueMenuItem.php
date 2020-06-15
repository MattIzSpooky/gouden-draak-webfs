<?php

namespace App\Rules;

use App\MenuItem;
use Illuminate\Contracts\Validation\Rule;

class UniqueMenuItem implements Rule
{
    private $addition;

    private $ignoreId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($addition, $ignoreId = null)
    {
        $this->addition = $addition;
        $this->ignoreId = $ignoreId;
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
        $menuItem = MenuItem::where([
            ['menu_number', $value],
            ['addition', $this->addition],
            ['id', '<>', $this->ignoreId]
        ])->first();

        return empty($menuItem);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Given menuNumber and addition are not unique';
    }
}
