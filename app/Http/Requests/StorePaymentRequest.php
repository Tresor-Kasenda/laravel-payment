<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $allowedCountries = ['+243', '+256', '+254'];

        return [
            'plan_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'full_name' => ['required', 'string', 'max:255'],
            'country_code' => ['required', Rule::in($allowedCountries)],
            'phone_number' => ['required', 'string', 'max:20'],
        ];
    }
}
