<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    protected $redirect = "/admin#products";
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->admin? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:products,name'],
            'value'=> ['required'],
        ];
    }
    public function messages(){
        return [
            'name.required'=> 'Por favor, insira um nome para o produto.',
            'name.unique'=> 'Já existe um produto com esse nome.',
            'images.required'=> 'Por favor, insira pelo menos uma imgaem.',
            'value.required'=> 'Por favor, insira um preço.'
        ];
    }
}
