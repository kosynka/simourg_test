<?php

namespace App\Model;

class Field
{
    public int $id;
    public int $process_id;
    public string $name;
    public string $type;
    public ?string $value;
    public ?string $number_format;
    public ?string $date_format;

    public function __construct(
        int $id,
        int $process_id,
        string $name,
        string $type,
        string $value = null,
        string $number_format = null,
        string $date_format = null,
    )
    {
        $this->id = $id;
        $this->process_id = $process_id;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->number_format = $number_format;
        $this->date_format = $date_format;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProcessId(): int
    {
        return $this->process_id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setNumberFormat(string $number_format): self
    {
        $this->number_format = $number_format;

        return $this;
    }

    public function getNumberFormat(): ?string
    {
        return $this->number_format;
    }

    public function setDateFormat(string $date_format): self
    {
        $this->date_format = $date_format;

        return $this;
    }

    public function getDateFormat(): ?string
    {
        return $this->date_format;
    }
}
