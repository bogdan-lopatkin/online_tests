<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
        request()->flashOnly('name');
        return [
            'name' => 'required|unique:categories|min:3|max:50'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Название категории обязательно',
            'name.unique'  => 'Название должно быть уникальным',
            'name.min'  => 'Название не может быть короче :min',
            'name.max'  => 'Название не может быть длиннее :max',
        ];
    }

}
