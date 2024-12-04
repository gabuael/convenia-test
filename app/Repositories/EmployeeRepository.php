<?php

namespace App\Repositories;

use App\DTO\EmployeeDTO;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function store(EmployeeDTO $employeeDTO): Employee
    {
        return Employee::create($employeeDTO->toArray());
    }

    public function update(Employee $employee, EmployeeDTO $employeeDTO): Employee
    {
        $employee->update($employeeDTO->toArray());
        $employee->fresh();
        return $employee;
    }
}