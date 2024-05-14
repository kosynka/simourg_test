<?php

declare(strict_types=1);

namespace App\Model;

class Process
{
    private int $id;
    private ?string $name;
    /**
     * @var Field[]|[]
     */
    private $fields = [];

    public function __construct(int $id, string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Field[]|[]
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
