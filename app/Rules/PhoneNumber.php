<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $error_message;
    public function __construct()
    {
        
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
       if(!Str::startsWith($value, '251')){
           $this->error_message = 'phone number must start with 251';
           return false;
       }elseif(Str::length($value) != 12){
           $this->error_message = 'length of the phone number must be 9 with out country code';
           return false;
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
        return $this->error_message;

    }
}
