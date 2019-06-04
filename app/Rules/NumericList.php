<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumericList implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
    	if(!is_array($value)){
    		return false;
		}

		foreach($value as $v) {
			if(!is_int($v)){
				return false;
			}
		}
		return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must be numeric list.';
    }
}
