<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return $this->user()->id == $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','between:3,255', Rule::unique('users')->ignore(auth()->user()->id)],
            'email' => ['required','between:3,255', Rule::unique('users')->ignore(auth()->user()->id)],
            'password' => ['required_with:password_confirmation','nullable', 'between:8,255','confirmed'],
            'current_password' => ['required',
                function($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail('Вы неверно ввели текущий пароль');
                    }
                }]
        ];
    }

    public function messages()
    {
        return [
            'name.between' => 'Длина логина не должна быть короче :min и длиннее :max символов ',
            'name.required' => 'Логин обязателен',
            'name.unique' => 'Логин должен быть уникален',
            'email.unique' => 'Email должен быть уникален',
            'password.confirmed' => 'Пароли не совпадают',
            'password.required_with' => 'Новый пароль обязателен к заполнению если подтверждение пароля заполнено',
            'password.between' => 'Длина пароля должна быть от :min до :max символов',
            'current_password.required' => 'Текущий пароль обязателен',
        ];
    }
}
