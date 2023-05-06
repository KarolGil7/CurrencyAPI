<?php

namespace App\Http\Requests;

use App\Helpers\AllowedTypesOfCurrenciesHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CurrencyAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d'],
            'currency' => ['required', Rule::in(AllowedTypesOfCurrenciesHelper::getCurrencyTypes())],
            'amount' => ['required', 'numeric', 'min:0.01']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'currency' => strtoupper($this->currency),
        ]);
    }
}
