<?php

namespace Jakefeeley\ReqResPackage;

class User implements \JsonSerializable
{
    /**
     * The user's id.
     * @var int
     */
    private int $id;

    /**
     * The user's name.
     * @var string
     */
    private string $name;

    /**
     * The user's job.
     * @var string
     */
    private string $job;

    /**
     * The user's created at.
     * @var string
     */
    private string $createdAt;

    /**
     * Create a new User instance.
     *
     * @param int $id
     * @param string $name
     * @param string $job
     * @param string $createdAt
     */
    public function __construct(int $id, string $name = '', string $job = '', string $createdAt = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->job = $job;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the user's id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the user's job.
     *
     * @return string
     */
    public function getJob(): string
    {
        return $this->job;
    }

    /**
     * Get the user's created at.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Specify data which should be serialised to JSON.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'job' => $this->job,
            'createdAt' => $this->createdAt,
        ];
    }
}
