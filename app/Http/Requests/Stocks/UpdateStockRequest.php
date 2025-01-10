<?php

namespace App\Http\Requests\Stocks;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'unique_code' => ['required', 'string', 'max:255'],
            'therapeutic_category' => ['required', 'string', 'max:255'],
            'manufacturer' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'sale_price' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'numeric'],
        ];
    }
}
