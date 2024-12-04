<?php

namespace App\Repositories\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\Employee;

interface EmployeeRepositoryInterface
{
    public function store(EmployeeDTO $employeeDTO): Employee;
    public function update(Employee $employee, EmployeeDTO $employeeDTO): Employee;
}