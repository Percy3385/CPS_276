<?php

class Db_conn
{

    private $conn;

    /*
     * This class connects to the database.
     * Database credentials are loaded from an external configuration file.
     */

    public function dbOpen()
    {

        try {

            // Load database credentials from external configuration file
            $config = require __DIR__ . '/../../../db_config.php';

            $dbHost = $config['host'];
            $dbName = $config['database'];
            $dbUsr  = $config['username'];
            $dbPass = $config['password'];

            // Establish PDO connection
            $this->conn = new PDO(
                'mysql:host=' . $dbHost . ';dbname=' . $dbName,
                $dbUsr,
                $dbPass
            );

            // Set PDO attributes
            $this->conn->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

            $this->conn->setAttribute(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
                true
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conn;
        } catch (PDOException $e) {

            error_log($e->getMessage());
            throw new RuntimeException(
                "Database connection failed."
            );
        }
    }
}
