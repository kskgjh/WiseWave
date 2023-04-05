<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class bannerImgRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'image'=> ['required'],
            'title'=> ['required', 'unique:banner_images,title'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'=> 'Por favor insira uma imagem.',
            'title.required'=> 'Por favor insira um titulo para a imagem.',
            'title.unique'=> 'O título inserido ja existe.'
        ];
    }
}
