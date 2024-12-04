<?php

namespace App\Http\Controllers;

use App\DTO\EmployeeDTO;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService)
    {
    }
    public function store(StoreEmployee $request)
    {
        return $this->employeeService->store(
            EmployeeDTO::fromArray($request->validated())
        );
    }

    public function update(UpdateEmployee $request, Employee $employee)
    {
        return $this->employeeService->update(
            $employee,
            EmployeeDTO::fromArrayWithEmployData($request->validated(), $employee)
        );
    }
}
