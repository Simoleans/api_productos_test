<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductos extends FormRequest
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
            'codigo' => 'required|unique:productos',
            'nombre' => 'required|unique:productos',
            'descripcion' => 'required|max:255',
            'precio' => 'required',
            'stock' => 'required|integer',
            'imagen' => 'mimes:jpeg,jpg,png,gif|required|image|max:7000',
        ];
    }
}
