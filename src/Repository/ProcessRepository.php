<?php

declare(strict_types=1);

namespace App\Repository;

use App\DB;
use App\Model\Process;

class ProcessRepository
{
    private string $table = 'processes';

    public function findOne(int $id): ?Process
    {
        $connection = DB::getInstance();
        $statement = $connection->query("SELECT * FROM {$this->table} WHERE id = {$id}");
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $process = new Process($result['id'], $result['name']);

        $fieldRepository = new FieldRepository();
        $fields = $fieldRepository->fetchAll($id);
        $process->setFields($fields);

        return $process;
    }

    public function fetchAll(array $params = [], int $limit = 15, int $offset = 0): array
    {
        $connection = DB::getInstance();
        $sql = "SELECT * FROM {$this->table}";

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
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $fieldRepository = new FieldRepository();

        foreach ($result as $process) {
            $fields = $fieldRepository->fetchAll($process['id']);

            $processModel = new Process(
                $process['id'],
                $process['name']
            );

            $processModel->setFields($fields);

            $processes[] = $processModel;
        }

        return $processes;
    }

    public function create(string $name = null): ?Process
    {
        $connection = DB::getInstance();
        $sql = "INSERT INTO {$this->table} (name) VALUES ('{$name}')";
        $statement = $connection->prepare($sql);
        $statement->execute();

        if ($statement->rowCount() === 1) {
            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($result === false) {
                return null;
            }

            return new Process(
                $result['id'],
                $result['name']
            );
        }

        return null;
    }

    public function addFields(int $id, array $data): Process
    {
        $fieldRepository = new FieldRepository();
        $fieldRepository->storeProcessFields($id, $data);

        return $this->findOne($id);
    }
}
