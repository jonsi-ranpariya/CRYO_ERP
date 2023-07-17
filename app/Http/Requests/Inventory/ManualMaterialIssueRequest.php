<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ManualMaterialIssueRequest extends FormRequest
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
            'materialIssueList' => 'required',
            'materialIssueList.*.canIssueQty' => 'required|numeric|min:1'
        ];
    }

    /**
     * Set the validation attributes that apply to the response.
     *
     * @return array
     */
    public function attributes(): array
    {
        return  [
            'materialIssueList' => 'Material Item List',
            'materialIssueList.*.canIssueQty' => 'Material Issue List Issue Qty'
        ];
    }
}
