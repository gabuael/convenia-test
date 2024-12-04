<?php
namespace App\Services;

use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Validator;

class CsvValidator
{
    protected array $requiredHeaders = ['name', 'email', 'cpf', 'city', 'state'];

    public function validate(string $filePath): array
    {
        $errors = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            if ($missingHeaders = array_diff($this->requiredHeaders, $header)) {
                $errors[] = 'Missing headers: ' . implode(', ', $missingHeaders);
            } else {
                $rowNumber = 1;
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $rowData = array_combine($header, $row);

                    $rules = (new StoreEmployee())->rules();
                    unset($rules['manager_id']);

                    $validator = Validator::make($rowData, $rules);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                    }
                    $rowNumber++;
                }
            }

            fclose($handle);
        } else {
            $errors[] = 'Unable to read the file.';
        }

        return $errors;
    }
}