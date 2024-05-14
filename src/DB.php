<?php

declare(strict_types=1);

namespace App;

use \PDO;

/**
 * Class DB
 * A singleton class for managing database connections.
 */
class DB
{
    /**
     * The PDO instance for database connection.
     */
    protected static ?PDO $instance;

    /**
     * DB constructor.
     * This constructor is declared protected to prevent direct instantiation of the class.
     */
    protected function __construct()
    {
    }

    /**
     * Get the singleton instance of the database connection.
     */
    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
            $db_info = array(
                "db_host" => "localhost",
                "db_port" => "3306",
                "db_user" => "root",
                "db_pass" => "sayat2000",
                "db_name" => "simourg",
                "db_charset" => "UTF-8"
            );

            try {
                self::$instance = new PDO(
                    "mysql:host=" . $db_info['db_host'] .
                    ';port=' . $db_info['db_port'] .
                    ';dbname=' . $db_info['db_name'],
                    $db_info['db_user'],
                    $db_info['db_pass'],
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');
            } catch (\PDOException $error) {
                exit('Connection failed: ' . $error->getMessage());
            }
        }

        return self::$instance;
    }
}
