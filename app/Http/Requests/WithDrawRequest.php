<?php

namespace App\Http\Requests;

use App\Rules\WithdrawalRule;
use Illuminate\Foundation\Http\FormRequest;

class WithDrawRequest extends FormRequest
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
            'amount' => ['required','gt:100',new WithdrawalRule],
        ];
    }
}
