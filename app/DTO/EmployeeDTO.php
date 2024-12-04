<?php

namespace App\DTO;

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
}