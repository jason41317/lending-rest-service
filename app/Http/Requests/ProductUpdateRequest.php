<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'unit_id' => 'required|not_in:0',
            'category_id' => 'required|not_in:0',
            'supplier_id' => 'required|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required'
        ];
    }
}
