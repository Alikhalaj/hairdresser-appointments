<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            'name' => 'required|string',
            'state'=> 'required|string',
            'city'=> 'required|string',
            'zip'=> 'required|integer',
            'address'=> 'required|string',
            'credit_number'=> 'required|integer',
            'openin_closein'=> 'required|string',
            'description'=> 'required',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
