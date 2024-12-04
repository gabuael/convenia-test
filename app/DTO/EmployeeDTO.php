<?php

namespace App\DTO;

use App\Models\Employee;
class EmployeeDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $cpf,
        public string $city,
        public string $state,
        public int $manager_id
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'city' => $this->city,
            'state' => $this->state,
            'manager_id' => $this->manager_id,
        ];
    }

    public static function fromArray(array $array): EmployeeDTO
    {
        return new self(
            $array['name'],
            $array['email'],
            $array['cpf'],
            $array['city'],
            $array['state'],
            $array['manager_id']
        );
    }

    public static function fromArrayWithEmployData(array $array, Employee $employee): EmployeeDTO
    {
        return new self(
            $array['name'] ?? $employee->name,
            $array['email'] ?? $employee->email,
            $array['cpf'] ?? $employee->cpf,
            $array['city'] ?? $employee->city,
            $array['state'] ?? $employee->state,
            $array['manager_id'] ?? $employee->manager_id
        );
    }
}