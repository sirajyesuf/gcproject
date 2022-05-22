<?php

namespace App\Rules;

use App\Services\GeneralServices;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class WithdrawalRule implements Rule
{
    
    private $serviceProvider;
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();
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
        $value = (int)$value;
        $balance = (new GeneralServices)->serviceProviderTotalBalance($this->serviceProvider);
        if($value > $balance){
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
        return 'you can not request more than your balance';
    }
}
