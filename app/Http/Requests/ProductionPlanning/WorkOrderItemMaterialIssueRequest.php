<?php

namespace App\Http\Requests\ProductionPlanning;

use App\Models\ProductionPlanning\WorkOrderItem;
use Illuminate\Foundation\Http\FormRequest;

class WorkOrderItemMaterialIssueRequest extends FormRequest
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
        if ($this->filled('workOrderItemId')) {
            $workOrder = WorkOrderItem::find($this->workOrderItemId, ['itemReqQty', 'itemPendingQty', 'itemIssueQty']);
            $maxQty = $workOrder->itemPendingQty;

            return [
                "canIssueQty" => "required|numeric|min:1|max:$maxQty"
            ];
        } else {
            return [
                "canIssueQty" => "required"
            ];
        }
    }

    /**
     * Set the attribute that apply to the response.
     *
     * @return array
     */
    public function attributes(): array
    {
        return  [
            'canIssueQty' => 'Issue QTY'
        ];
    }
}
