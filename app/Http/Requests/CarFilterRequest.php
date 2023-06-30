<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand'=> 'string|nullable',
            'model'=>'string|nullable',
            'year'=> 'string|nullable',
            'price_start'=>'string|nullable',
            'price_end'=>'string|nullable'
        ];
    }
}
