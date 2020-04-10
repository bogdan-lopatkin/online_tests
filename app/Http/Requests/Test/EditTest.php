<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class EditTest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->checkRole(1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'category_id' => 'required',
            'description' => 'required|min:3',
            'max_time' => 'required',
            'difficulty' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Название теста обязательно',
            'name.min'  => 'Название не может быть короче :min',
            'category_id' => 'Категория обязательна к заполнению',
            'description.required' => 'Описание теста обязательно',
            'description.min'  => 'Описание не может быть короче :min',
            'max_time' => 'Время на выполнение обязательно к заполнению',
            'difficulty' => 'Сложность обязательна к заполнению',

        ];
    }
}
