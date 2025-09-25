<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'amount' => 'required',
            'date' => [
                'exclude_if:override,true',
                'required',
                Rule::unique('expenses')->where(function (Builder $query) {
                    $query->where('category_id', $this->input('category_id'))
                        ->where('amount', $this->input('amount') * 100);
                }),
            ],
            'category_id' => 'required',
            'vendor_id' => 'nullable',
            'override' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'date.unique' => 'Expense has already been entered',
        ];
    }
}
