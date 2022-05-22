<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddAndReviewRequest extends FormRequest
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
            'rate'                 => 'required|integer|gt:0|lte:5',
            'service_provider_id'  => 'required|exists:service_providers,id',
            'review'               => 'nullable|string',
        ];
    }
}
