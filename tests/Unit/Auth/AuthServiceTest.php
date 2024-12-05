<?php

use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Contracts\Auth\AuthRepositoryInterface;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Tests\Pest;

it('returns a token when login is successful', function () {
  // Arrange
  $email = 'user@example.com';
  $password = 'password123';
  $hashedPassword = 'hashed-password';

  // Mock the Hash facade
  Hash::shouldReceive('check')->with($password, $hashedPassword)->andReturn(true);

  $mockUser = Mockery::mock(
    User::class,
    function (MockInterface $mockInterface) {
      $mockInterface->shouldReceive('createToken')
        ->with('Password')
        ->andReturn((object) ['accessToken' => 'test-token']);
    }
  )->makePartial();

  $mockUser->password = $hashedPassword;

  $authRepositoryMock = Mockery::mock(
    AuthRepositoryInterface::class,
    function (MockInterface $mockInterface) use ($mockUser, $email) {
      $mockInterface->shouldReceive('login')
        ->with($email)
        ->andReturn($mockUser);
    }
  );
  $authService = new AuthService($authRepositoryMock);

  // Act
  $response = $authService->login($email, $password);

  // Assert
  expect($response)->toBe([
    'response' => ['token' => 'test-token'],
    'status' => 200
  ]);
});

it('returns an error when login fails', function () {
  // Arrange
  $email = 'user@example.com';
  $password = 'invalidPassword';

  Hash::shouldReceive('check')->with($password, 'correctPassword')->andReturn(false);

  $mockUser = Mockery::mock(User::class)->makePartial();
  $mockUser->password = 'correctPassword';

  $authRepositoryMock = Mockery::mock(
    AuthRepository::class,
    function (MockInterface $mockInterface) use ($email, $mockUser) {
      $mockInterface->shouldReceive('login')
        ->with($email)
        ->andReturn($mockUser);
    }
  );
  $authService = new AuthService($authRepositoryMock);

  // Act
  $response = $authService->login($email, $password);

  // Assert
  expect($response)->toBe([
    'response' => ['message' => 'Invalid password or email'],
    'status' => 422
  ]);
});

it('returns an error when user is not found', function () {
  // Arrange
  $email = 'nonexistent@example.com';
  $password = 'password123';

  $authRepositoryMock = Mockery::mock(
    AuthRepository::class,
    function (MockInterface $mockInterface) use ($email) {
      $mockInterface->shouldReceive('login')
        ->with($email)
        ->andReturn(null);
    }
  );
  $authService = new AuthService($authRepositoryMock);

  // Act
  $response = $authService->login($email, $password);

  // Assert
  expect($response)->toBe([
    'response' => ['message' => 'Invalid password or email'],
    'status' => 422
  ]);
});
