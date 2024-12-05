<?php

use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Storage;
use App\Services\CsvValidator;
use Tests\Pest;

it('validates a valid CSV file', function () {
    // Arrange
    Validator::shouldReceive('make')
        ->once()
        ->andReturn(Mockery::mock('Illuminate\Contracts\Validation\Validator', function ($mock) {
            $mock->shouldReceive('fails')->andReturn(false);  // Simula que a validação foi bem-sucedida
        }));

    Storage::fake('local');
    $csvContent = "name,email,cpf,city,state\nJohn Doe,john@example.com,123.456.789-00,City,SP\n";
    $filePath = 'csv/test.csv';

    Storage::put($filePath, $csvContent);

    $absolutePath = Storage::path($filePath);

    $validator = new CsvValidator();

    // Act
    $errors = $validator->validate($absolutePath);

    // Assert
    expect($errors)->toBeEmpty();

    // Cleanup
    Storage::delete($filePath);
});

it('returns errors for an invalid CSV file', function () {
    // Arrange
    Storage::fake('local');
    $csvContent = "name,email,cpf,city\nJohn Doe,john@example.com,123.456.789-00,City\n";
    $filePath = 'csv/invalid_test.csv';

    Storage::put($filePath, $csvContent);

    $absolutePath = Storage::path($filePath);

    $validator = new CsvValidator();

    // Act
    $errors = $validator->validate($absolutePath);

    // Assert
    expect($errors)->toContain('Missing headers: state');

    // Cleanup
    Storage::delete($filePath);
});

it('returns errors for invalid CSV row data', function () {
    // Arrange
    Validator::shouldReceive('make')
        ->once()
        ->andReturn(Mockery::mock('Illuminate\Contracts\Validation\Validator', function ($mock) {
            $mock->shouldReceive('fails')->andReturn(true);  // Simula que a validação falhou
            $mock->shouldReceive('errors')->andReturn(collect([0 => 'The cpf format is invalid.']));
        }));
    Storage::fake('local');
    $csvContent = "name,email,cpf,city,state\nJohn Doe,john@example.com,invalid-cpf,City,SP\n"; // CPF inválido
    $filePath = 'csv/invalid_data_test.csv';

    Storage::put($filePath, $csvContent);

    $absolutePath = Storage::path($filePath);

    $validator = new CsvValidator();

    // Act
    $errors = $validator->validate($absolutePath);

    // Assert
    expect($errors)->toContain('Row 1: The cpf format is invalid.');

    // Cleanup
    Storage::delete($filePath);
});
