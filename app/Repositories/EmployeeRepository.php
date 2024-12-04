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
}