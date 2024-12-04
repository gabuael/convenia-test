<?php

namespace App\Http\Requests;

use App\UtilsTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployee extends FormRequest
{
    use UtilsTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->id === $this->employee->manager_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'string|email|unique:employees,email',
            'cpf' => 'string|unique:employees,cpf',
            'city' => 'string',
            'state' => 'string',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->cpf) {
            $this->merge([
                "cpf" => $this->formatCpf($this->cpf)
            ]);
        }
    }
}
