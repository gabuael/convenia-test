<?php

namespace App\Http\Controllers;

use App\DTO\EmployeeDTO;
use App\Http\Requests\StoreEmployee;
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
            new EmployeeDTO(
                $request->name,
                $request->email,
                $request->cpf,
                $request->city,
                $request->state,
                $request->manager_id
            )
        );
    }
}
