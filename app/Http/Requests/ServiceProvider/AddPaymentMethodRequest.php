<?php

namespace App\Http\Requests\ServiceProvider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddPaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method'  =>  ['required',Rule::in([1,2,3])],// 1 for cbe , 2 for abyssinia,3 for dashen
            'account_number'  => ['required'],
            'account_holder'  => ['required','string'],
        ];
    }
}
