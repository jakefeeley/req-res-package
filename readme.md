# ReqRes Package

This package provides a service for interacting with the ReqRes API to retrieve and create user information. It is designed to be framework-agnostic and can be used in any PHP project, including Laravel, Drupal, and Wordpress. The package is written to modern PSR standards targeting PHP 8.2 and includes unit tests for the provided services.

## Installation

You can install the package via Composer. Run the following command:

```bash
composer require jakefeeley/reqres-package
```

## Usage

### Setting Up

First, you need to create an instance of the `UserService` class. This requires an instance of the Guzzle HTTP client.

```php
use Jakefeeley\ReqResPackage\UserService;
use GuzzleHttp\Client;

$client = new Client();
$userService = new UserService($client);
```

### Retrieving a User by ID

To retrieve a user by their ID, use the `getUserById` method:

```php
$user = $userService->getUserById(1);
echo $user->getName();  //Outputs: "George Bluth"
```

### Retrieving a List of Users

To retrieve a paginated list of users, use the `getUsers` method:

```php
$users = $userService->getUsers(1);
foreach ($users as $user) {
    echo $user->getName();
}
```

### Creating a New User

To create a new user, use the `createUser` method:

```php
$newUser = $userService->createUser('John Doe', 'Engineer');
echo $newUser->getId();
```

## Classes

### UserService

This class provides methods to interact with the ReqRes API.

#### Methods

- **getUserById(int $id): User**

  Retrieves a user by their ID. Throws an exception if the user is not found or the API request fails.

- **getUsers(int $page = 1): array**

  Retrieves a list of users for the specified page. Throws an exception if no users are found or the API request fails.

- **createUser(string $name, string $job): User**

  Creates a new user with the specified name and job. Throws an exception if the user creation fails or the API request fails.

### User

This class represents a user and implements the `JsonSerializable` interface.

#### Properties

- **id**: The user's ID.
- **name**: The user's name.
- **job**: The user's job.
- **createdAt**: The user's creation date.

#### Methods

- **getId(): int**

  Returns the user's ID.

- **getName(): string**

  Returns the user's name.

- **getJob(): string**

  Returns the user's job.

- **getCreatedAt(): string**

  Returns the user's creation date.

- **jsonSerialize(): array**

  Specifies the data which should be serialised to JSON.

## Unit Tests

This package includes unit tests to ensure the correctness of the provided services. The tests utilises PHPUnit and Guzzle's MockHandler to simulate API responses.

To run the tests, use the following command:

```bash
./vendor/bin/phpunit
```

## License

This package is open-sourced software licensed under the MIT license. See the LICENSE file for more information.
