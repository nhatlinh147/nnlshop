<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateFormSignInAdmin extends FormRequest
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
            'account_name' => 'required|max:255',
            'account_password' => 'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'account_name.required' => 'Tên tài khoản không được bỏ trống',
            'account_password.required' => 'Mật khẩu không được bỏ trống',
        ];
    }
}