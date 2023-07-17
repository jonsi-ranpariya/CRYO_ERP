<?php

namespace App\Http\Requests\Despatch;

use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Foundation\Http\FormRequest;

class NewChallanInvoiceItemUpdateRequest extends FormRequest
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
        $salesOrderItemId = $this->salesOrderItemId;
        $salesOrderItem = SalesOrderItems::find($salesOrderItemId);
        $totalUsedQty = NewChallanInvoiceItems::query()
            ->where([
                'salesOrderItemId' => $salesOrderItemId,
                'salesOrderId' => $salesOrderItem->salesOrderId
            ])->sum('itemQuantity');
        $newChallanItemsQty = NewChallanInvoiceItems::find($this->_id,['itemQuantity'])->itemQuantity;
        $salesOrderItemPendingQuantity = $salesOrderItem->itemQuantity - $totalUsedQty;
        $maxQty = $newChallanItemsQty + $salesOrderItemPendingQuantity;

        return [
            'itemQuantity' => "required|numeric|max:$maxQty|min:0"
        ];
    }

    public function messages(): array
    {
        return [
            'itemQuantity.max' => 'The Item Quantity not be greater than :max.',
            'itemQuantity.min' => 'The Item Quantity must be at least :min.'
        ];
    }
}
