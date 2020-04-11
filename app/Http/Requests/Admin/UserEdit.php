<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserEdit extends FormRequest
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
            'name' => ['required','between:3,255', Rule::unique('users')->ignore($this->route('user')) ],
            'email' => ['required','between:3,255', Rule::unique('users')->ignore($this->route('user')) ],
            'password' => ['nullable', 'between:8,255'],
            'role.0' =>"required",
        ];
    }
    public function messages()
    {
        return [
            'name.between' => 'Длина логина не должна быть короче :min и длиннее :max символов ',
            'name.required' => 'Логин обязателен',
            'name.unique' => 'Логин должен быть уникален',
            'email.unique' => 'Email должен быть уникален',
            'password.between' => 'Длина пароля должна быть от :min до :max символов',
        ];
    }
}
