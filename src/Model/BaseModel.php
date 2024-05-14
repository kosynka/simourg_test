<?php

namespace App\Model;

use App\DB;

abstract class BaseModel
{
    protected int $id;
    protected static string $table;
    protected array $fields = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public static function fetchAll(array $params = [], int $limit = 15, int $offset = 0): array
    {
        $table = self::$table;

        $connection = DB::getInstance();
        $sql = "SELECT * FROM {$table}";

        if (!empty($params)) {
            $sql .= " WHERE ";
        }

        foreach ($params as $column => $value) {
            $sql .= "{$column} = :'{$column}'";
        }

        $statement = $connection->prepare($sql . " LIMIT {$limit} OFFSET {$offset}");

        foreach ($params as $column => $value) {
            $statement->bindValue(":{$column}", $value, \PDO::PARAM_STR);
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findOne(int $id): ?self
    {
        $table = self::$table;

        $connection = DB::getInstance();
        $statement = $connection->query("SELECT * FROM {$table} WHERE id = {$id}");

        $statement->fetch(\PDO::FETCH_ASSOC);

        return $statement ? new static($table) : null;
    }

    public function create(): self
    {
        $table = self::$table;
        $fields = get_object_vars($this);

        $connection = DB::getInstance();
        $columns = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $statement = $connection->prepare($sql);
        $statement->execute(array_values($fields));

        return new static($table);
    }

    abstract protected function save(): bool;

    public function delete(): bool
    {
        $table = self::$table;

        $connection = DB::getInstance();
        $sql = "DELETE FROM {$table} WHERE id = {$this->id}";

        return $connection->exec($sql);
    }
}
