<?php

namespace App\Repositories;

use App\DTO\EmployeeDTO;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function list(int $managerId): Collection
    {
        return Employee::where('manager_id', $managerId)->get();
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }
}