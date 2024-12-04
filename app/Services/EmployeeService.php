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
    public function store(EmployeeDTO $employeeDTO): Employee
    {
        return $this->employeeRepository->store($employeeDTO);
    }

    public function update(Employee $employee, EmployeeDTO $employeeDTO): Employee
    {
        return $this->employeeRepository->update($employee, $employeeDTO);
    }
}