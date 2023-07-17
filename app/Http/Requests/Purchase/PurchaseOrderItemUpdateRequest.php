<?php

namespace App\Http\Requests\Purchase;

use App\Models\Inventory\GoodsReceiptNoteItem;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderItemUpdateRequest extends FormRequest
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
        $upSum = GoodsReceiptNoteItem::query()->where([
            'poItemId' => $this->_id,
            'purchaseOrderId' => $this->purchaseOrderId
        ])->sum('poQuantityUp');

        return [
            'itemQuantityUp' => "required|numeric|min:$upSum"
        ];
    }

    public function messages(): array
    {
        return [
            'itemQuantityUm.min' => 'Item Quantity (:min) already in used.'
        ];
    }
}
