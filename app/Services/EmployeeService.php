<?php

namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class EmployeeService
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepository)
    {
    }
    public function store(EmployeeDTO $employeeDTO)
    {
        return $this->employeeRepository->store($employeeDTO);
    }
}