<?php

namespace App\Http\Requests\ProductionPlanning;

use App\Models\ProductionPlanning\WoRequisitionItems;
use Illuminate\Foundation\Http\FormRequest;

class IssueMaterialForRequisitionRequest extends FormRequest
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
        if ($this->filled('requisitionItemId')){
            $requisitionItemId = $this->requisitionItemId;
            $item = WoRequisitionItems::find($requisitionItemId, ['itemPendingQty']);

            return [
                "requisitionItemId" => "required",
                "canIssueQty" => "required|numeric|min:1|max:$item->itemPendingQty"
            ];

        } else {
            return [
                "requisitionItemId" => "required",
            ];
        }
    }

    /**
     * Set the validation attribute that apply to the response.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'canIssueQty' => 'Issue QTY',
            'requisitionItemId' => 'Item'
        ];
    }
}
