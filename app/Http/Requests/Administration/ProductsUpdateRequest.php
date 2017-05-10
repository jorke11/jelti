<?php

namespace App\Http\Requests\Administration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class ProductsUpdateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function __construct(Route $route) {
        $this->route = $route;
    }

    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
//        dd($this->get(""));exit;
        $prod = $this->route('product');
        
        
        return [
            'category_id' => 'required',
            'supplier_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'short_description' => 'required',
//            'reference' => 'required|max:255|unique:products,reference,'.$this->route()->getparameter("product"),
            'reference' => 'required|max:255|unique:products,reference,' . $prod,
            'units_supplier' => 'required',
            'units_sf' => 'required',
            'cost_sf' => 'required',
            'tax' => 'required',
            'price_sf' => 'required',
            'price_cust' => 'required',
            'minimum_stock' => 'required',
        ];
    }

}
