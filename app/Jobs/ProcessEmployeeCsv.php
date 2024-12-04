<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CsvProcessedMail;
use App\Models\Employee;
use App\DTO\EmployeeDTO;
use Illuminate\Support\Facades\Log;

class ProcessEmployeeCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $user;

    public function __construct(string $filePath, $user)
    {
        $this->filePath = $filePath;
        $this->user = $user;
    }

    public function handle()
    {
        if (($handle = fopen(storage_path('app/private/' . $this->filePath), 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data = array_combine($header, $row);

                $employeeDto = EmployeeDTO::fromArray([
                    ...$data,
                    'manager_id' => $this->user->id
                ]);

                Employee::create($employeeDto->toArray());
            }

            fclose($handle);
        }

        Mail::to($this->user->email)->send(new CsvProcessedMail());
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Failed to process CSV: ' . $exception->getMessage());
    }
}
