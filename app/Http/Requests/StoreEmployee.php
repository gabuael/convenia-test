<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'cpf' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'manager_id' => 'required|exists:users,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            "manager_id" => $this->user()->id
        ]);
    }
}
