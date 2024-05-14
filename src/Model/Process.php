<?php

namespace App\Model;

use App\DB;

class Process extends BaseModel
{
    public static string $table = 'processes';
    public int $id;
    public string $name;

    /**
     * @var ProcessField[]
     */
    public array $fields = [];

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        parent::__construct($this->table);
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param ProcessField[] $fields
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public static function findOne(int $id): ?self
    {
        $table = self::$table;

        $connection = DB::getInstance();
        $statement = $connection->query("SELECT * FROM {$table} WHERE id = {$id}");

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $statement ? new static($table, $result['name']) : null;
    }

    protected function save(): bool
    {
        $fields = get_object_vars($this);

        $columns = implode(', ', array_keys($fields));
        $values = implode(', ', array_map(fn($field) => ":{$field}", array_keys($fields)));

        $connection = DB::getInstance();
        $statement = $connection->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");

        foreach ($fields as $column => $value) {
            $statement->bindValue(":{$column}", $value, \PDO::PARAM_STR);
        }

        return $statement->execute();
    }
}
