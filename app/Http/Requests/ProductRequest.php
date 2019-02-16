<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|max:300|unique:products,name',
                    'price' => 'required|numeric|between:0,99999999.99',
                    'stock' => 'nullable|numeric|between:1,32767',
                    'short_description' => 'required|max:400',
                    'description' => 'required',
                    'cover' => 'required|image'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|max:300|unique:products,name,'.$this->get('id'),
                    'price' => 'required|numeric|between:0,99999999.99',
                    'stock' => 'required|numeric|between:1,32767',
                    'short_description' => 'required|max:400',
                    'description' => 'required',
                    'cover' => 'image'
                ];
            }
            default:break;
        }
    }
}
