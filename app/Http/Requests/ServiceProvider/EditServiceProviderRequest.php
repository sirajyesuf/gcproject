<?php

namespace App\Http\Requests\ServiceProvider;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditServiceProviderRequest extends FormRequest
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
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric|gt:0',
            'type'=>['required','integer',Rule::in([1,2]),],
            'image'=>['required','image','max:3100'],
        ];
    }
}
