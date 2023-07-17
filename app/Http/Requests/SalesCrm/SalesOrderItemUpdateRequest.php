<?php

namespace App\Http\Requests\SalesCrm;

use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Foundation\Http\FormRequest;

class SalesOrderItemUpdateRequest extends FormRequest
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
        $salesOrderItem = SalesOrderItems::find($this->id);
        $totalUsedQty = NewChallanInvoiceItems::query()
            ->where([
                'salesOrderItemId' => $this->id,
                'salesOrderId' => $salesOrderItem->salesOrderId
            ])->sum('itemQuantity');

        return [
            'itemQuantity' => "required|numeric|min:$totalUsedQty"
        ];
    }

    public function messages(): array
    {
        return [
            'itemQuantity.min' => 'Item Quantity (:min) already in used.'
        ];
    }
}
