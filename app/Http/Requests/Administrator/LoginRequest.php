<?php

namespace App\Http\Requests\Administrator;

use App\Enums\UserTypeEnums;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->username == UserTypeEnums::SUPER) {
            return [
                'username' => 'required',
                'password' => 'required'
            ];
        } else {
            return [
                'username' => 'required',
                'password' => 'required',
                'companyId' => 'required'
            ];
        }
    }

    /**
     * Set the validation attributes that apply to the response.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
           'companyId' => 'Company',
           'username' => 'User ID'
        ];
    }
}
