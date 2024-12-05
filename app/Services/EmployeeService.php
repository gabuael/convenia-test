<?php

namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Jobs\ProcessEmployeeCsv;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EmployeeService
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepository, private CsvValidator $csvValidator)
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

    public function list(int $managerId): Collection
    {
        $cacheKey = 'employees_manager_' . $managerId;

        return Cache::remember($cacheKey, 60, function () use ($managerId) {
            return $this->employeeRepository->list($managerId);
        });
    }

    public function delete(Employee $employee): bool
    {
        return $this->employeeRepository->delete($employee);
    }

    public function importCsv($filePath, $fullPath): array
    {
        $errors = $this->csvValidator->validate($fullPath);

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        ProcessEmployeeCsv::dispatch($filePath, Auth::user());

        return ['message' => 'CSV uploaded successfully. Processing...'];

    }
}