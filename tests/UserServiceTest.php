<?php

namespace Jakefeeley\ReqResPackage\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Jakefeeley\ReqResPackage\UserService;
use Jakefeeley\ReqResPackage\User;

class UserServiceTest extends TestCase
{
    /**
     * The user service.
     * @var UserService
     */
    private UserService $userService;

    /**
     * Set up the test.
     * @return void
     */
    protected function setUp(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['data' => [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'job' => 'Engineer',
                'createdAt' => '2023-01-01T00:00:00.000Z'

            ]])),
            new Response(200, [], json_encode(['data' => [
                ['id' => 1, 'first_name' => 'John', 'last_name' => 'Doe', 'job' => 'Engineer'],
                ['id' => 2, 'first_name' => 'Jane', 'last_name' => 'Doe', 'job' => 'Engineer']
            ]])),
            new Response(201, [], json_encode([
                'id' => 100,
                'name' => 'John Doe',
                'job' => 'Engineer',
                'createdAt' => '2023-01-01T00:00:00.000Z'
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $this->userService = new UserService($client);
    }

    /**
     * Test the getUserById method.
     * @return void
     */
    public function testGetUserById(): void
    {
        $user = $this->userService->getUserById(1);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->getId());
        $this->assertEquals('John Doe', $user->getName());
    }

    /**
     * Test the getUsers method.
     * @return void
     */
    public function testGetUsers(): void
    {
        $users = $this->userService->getUsers();
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users[0]);
    }

    /**
     * Test the createUser method.
     * @return void
     */
    public function testCreateUser(): void
    {
        $user = $this->userService->createUser('John Doe', 'Engineer');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Engineer', $user->getJob());
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('2023-01-01T00:00:00.000Z', $user->getCreatedAt());
    }
}
