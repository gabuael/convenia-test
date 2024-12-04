<?php

namespace App\Http\Controllers;

use App\DTO\EmployeeDTO;
use App\Http\Requests\DeleteEmployee;
use App\Http\Requests\ImportCsvEmployee;
use App\Http\Requests\ListEmployee;
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

    public function list(ListEmployee $request)
    {
        return $this->employeeService->list($request->get('manager_id'));
    }

    public function delete(DeleteEmployee $request, Employee $employee)
    {
        return $this->employeeService->delete($employee);
    }

    public function importCsv(ImportCsvEmployee $request)
    {
        $filePath = $request->file('file')->store('csv_uploads');
        $fullPath = storage_path('app/private/' . $filePath);

        $response = $this->employeeService->importCsv($filePath, $fullPath);

        return response()->json(
            $response,
            array_key_exists('errors', $response) ? 422 : 202
        );
    }
}
