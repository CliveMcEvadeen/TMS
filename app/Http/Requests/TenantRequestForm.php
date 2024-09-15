<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequestForm extends FormRequest
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
            'name' => 'required|unique:tenants,name,'. ($this->tenant_id ? $this->tenant_id : 'NULL'),
            'contact_no' => 'required',
            'email' => 'required|unique:tenants,email,'. ($this->tenant_id ? $this->tenant_id : 'NULL'),
            'address' => 'required'
        ];
    }
}