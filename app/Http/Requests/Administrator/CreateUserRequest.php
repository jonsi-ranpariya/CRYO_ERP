<?php

namespace App\Http\Requests\Administrator;

use App\Enums\UserTypeEnums;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'companyId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users,username',
            'code' => 'required|unique:users,code',
            'role' => ['required', new EnumValue(UserTypeEnums::class)],
            'password' => 'required',
        ];
    }
}
