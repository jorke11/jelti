<?php

namespace App\Http\Requests\Administration;

use Illuminate\Foundation\Http\FormRequest;

class ProductsCreateRequest extends FormRequest
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
            'category_id' => 'required',
            'supplier_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'short_description' => 'required',
            'reference' => 'required|unique:products,reference|max:255',
            'units_supplier' => 'required',
            'units_sf' => 'required',
            'cost_sf' => 'required',
            'tax' => 'required',
            'price_sf' => 'required',
            'minimum_stock' => 'required',
        ];
    }
}
