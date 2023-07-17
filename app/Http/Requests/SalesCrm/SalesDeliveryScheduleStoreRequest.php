<?php

namespace App\Http\Requests\SalesCrm;

use Illuminate\Foundation\Http\FormRequest;

class SalesDeliveryScheduleStoreRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:0',
            'salesOrderQty' => 'required|numeric|min:0',
            'totalQuantity' => 'required|numeric|min:0',
        ];
    }

    /**
     * Set the validation attributes that apply to the response.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'quantity' => 'Quantity',
            'salesOrderQty' => 'Sales Order QTY',
            'totalQuantity' => 'Total Quantity',
        ];
    }
}
