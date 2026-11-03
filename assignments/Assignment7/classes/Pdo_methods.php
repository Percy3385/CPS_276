<?php

require_once "Db_conn.php";

class PdoMethods extends Db_conn
{

    private $sth;
    private $conn;
    private $db;
    private $error;

    /*
     * SELECT query with bound parameters
     */
    public function selectBinded($sql, $bindings)
    {

        $this->error = false;

        try {

            $this->db_connection();

            $this->sth = $this->conn->prepare($sql);

            $this->createBinding($bindings);

            $this->sth->execute();

            $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);

            $this->conn = null;

            return $result;
        } catch (PDOException $e) {

            error_log($e->getMessage());

            return 'error';
        }
    }


    /*
     * SELECT query without bound parameters
     */
    public function selectNotBinded($sql)
    {

        $this->error = false;

        try {

            $this->db_connection();

            $this->sth = $this->conn->prepare($sql);

            $this->sth->execute();

            $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);

            $this->conn = null;

            return $result;
        } catch (PDOException $e) {

            error_log($e->getMessage());

            return 'error';
        }
    }


    /*
     * INSERT, UPDATE, DELETE with bound parameters
     */
    public function otherBinded($sql, $bindings)
    {

        $this->error = false;

        try {

            $this->db_connection();

            $this->sth = $this->conn->prepare($sql);

            $this->createBinding($bindings);

            $this->sth->execute();

            $this->conn = null;

            return 'noerror';
        } catch (PDOException $e) {

            error_log($e->getMessage());

            return 'error';
        }
    }


    /*
     * INSERT, UPDATE, DELETE without parameters
     */
    public function otherNotBinded($sql)
    {

        $this->error = false;

        try {

            $this->db_connection();

            $this->sth = $this->conn->prepare($sql);

            $this->sth->execute();

            $this->conn = null;

            return 'noerror';
        } catch (PDOException $e) {

            error_log($e->getMessage());

            return 'error';
        }
    }


    /*
     * Establish database connection
     */
    private function db_connection()
    {

        $this->db = new Db_conn();

        $this->conn = $this->db->dbOpen();
    }


    /*
     * Create parameter bindings
     */
    private function createBinding($bindings)
    {

        foreach ($bindings as $value) {

            switch ($value[2]) {

                case "str":

                    $this->sth->bindValue(
                        $value[0],
                        $value[1],
                        PDO::PARAM_STR
                    );

                    break;

                case "int":

                    $this->sth->bindValue(
                        $value[0],
                        $value[1],
                        PDO::PARAM_INT
                    );

                    break;
            }
        }
    }
}
