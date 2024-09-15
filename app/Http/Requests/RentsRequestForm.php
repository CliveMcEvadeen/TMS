<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentsRequestForm extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'terms' => 'required',
            'rent_type' => 'required',
            'payment_method' => 'required',
            'penalty' => 'required',
            'discount' => 'required',
            'deposit' => 'required',
            'amount' => 'required',
            'status' => '',
            'notes' => '',
            'property_id' => 'required',
            'tenants_id' => 'required',
        ];
    }
}