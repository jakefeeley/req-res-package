<?php

namespace Jakefeeley\ReqResPackage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserService
{
    /**
     * The HTTP client.
     * @var Client
     */
    private Client $client;

    /**
     * Create a new UserService instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a user by id.
     *
     * @param int $id
     * @return User
     * @throws \Exception if user not found or API request fails
     */
    public function getUserById(int $id): User
    {
        try {
            $response = $this->client->get("https://reqres.in/api/users/{$id}");
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data'])) {
                return new User(
                    $data['data']['id'],
                    $data['data']['first_name'] . ' ' . $data['data']['last_name']
                );
            } else {
                throw new \Exception('User not found');
            }
        } catch (RequestException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }

    /**
     * Get a list of users.
     *
     * @param int $page
     * @return array
     * @throws \Exception if users not found or API request fails
     */
    public function getUsers(int $page = 1): array
    {
        try {
            $response = $this->client->get('https://reqres.in/api/users', ['query' => ['page' => $page]]);
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data']) && !isset($data['data'][0])) {
                $data['data'] = [$data['data']];
            }

            if (isset($data['data'])) {
                return array_map(function ($userData) {
                    return new User(
                        $userData['id'],
                        $userData['first_name'] . ' ' . $userData['last_name']
                    );
                }, $data['data']);
            } else {
                throw new \Exception('No users found');
            }
        } catch (RequestException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }

    /**
     * Create a user.
     *
     * @param string $name
     * @param string $job
     * @return User
     * @throws \Exception if user creation fails or API request fails
     */
    public function createUser(string $name, string $job): User
    {
        try {
            $response = $this->client->post('https://reqres.in/api/users', [
                'json' => ['name' => $name, 'job' => $job]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            $data = $data['data'] ?? $data;

            $name = $data['first_name'] ?? $data['name'];
            if (isset($data['last_name'])) {
                $name .= ' ' . $data['last_name'];
            }

            return new User(
                $data['id'],
                $name,
                $data['job'],
                $data['createdAt']
            );
        } catch (RequestException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
