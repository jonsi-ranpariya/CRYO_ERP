<?php

namespace App\Http\Requests\ProductionPlanning;

use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Foundation\Http\FormRequest;

class IssueQtyForJobCardRequest extends FormRequest
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
        $showIssueItemId = $this->showIssueItemId;
        if (empty($showIssueItemId)) {
            return [
                'showIssueItemId' => "required"
            ];
        }

        $item = ShowIssueItems::find($showIssueItemId, ['issueRequiredQty','issueItemQty']);
        $maxQty = (float)$item->issueRequiredQty - (float)$item->issueItemQty;

        return [
            'canIssueQty' => "required|numeric|max:$maxQty|min:1"
        ];
    }

    /**
     * Set the validation Message that apply to the response.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'canIssueQty.min' => 'The Issue QTY must be at least :min.',
            'canIssueQty.max' => 'The Issue QTY not be greater than :max.'
        ];
    }
}
