<?php

namespace App\Core;

class DB
{
    protected ?object $pdo = null;
    private string $table;

    public function __construct()
    {
        //connexion à la bdd via pdo
        try {

            $this->pdo = new \PDO('pgsql:host=172.18.0.2;dbname=easyCook;user=' . $_ENV["DB_USER"] . ';password=' . $_ENV["DB_PASSWORD"]);
        } catch (\PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }

        $table = get_called_class();
        $table = explode("\\", $table);
        $table = array_pop($table);
        $this->table = "easycook_" . strtolower($table);
    }

    public function getDataObject(): array
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    public function save()
    {
        $data = $this->getDataObject();

        if (empty($this->getId())) {
            $sql = "INSERT INTO " . $this->table . "(" . implode(",", array_keys($data)) . ") 
            VALUES (:" . implode(",:", array_keys($data)) . ")";
        } else {
            $sql = "UPDATE " . $this->table . " SET ";
            foreach ($data as $column => $value) {
                if (substr($column, 0, 2) === 'is') {
                    $data[$column] = ($value === true) ? "true" : "false";
                }
                $sql .= $column . "=:" . $column . ",";
            }
            $sql = substr($sql, 0, -1);
            $sql .= " WHERE id = " . $this->getId();
        };

        $queryPrepared = $this->pdo->prepare($sql);
        $success = $queryPrepared->execute($data);


        if (empty($this->getId())) {
            $lastInsertId = $this->pdo->lastInsertId();
            $this->setId($lastInsertId);
        }

        return $success;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function populate(int $id): object
    {
        $class = get_called_class();
        $object = new $class();
        return $object->getOneBy(["id" => $id], "object");
    }



    //$data = ["id"=>1] ou ["email"=>"y.skrzypczyk@gmail.com"]
    public function getOneBy(array $data, string $return = "array")
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE ";
        foreach ($data as $column => $value) {
            $sql .= " " . $column . "=:" . $column . " AND";
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
        if ($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        }
        return $queryPrepared->fetch();
    }
    public function delete()
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $this->getId();
        $queryPrepared = $this->pdo->prepare($sql);
        return $queryPrepared->execute();
    }

    public function countRows(): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchColumn();
    }

    public function getColumns(string $column): array
    {
        $sql = "SELECT " . $column . " FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getIdFromTable(string $column, string $value): int
    {
        $sql = "SELECT id FROM " . $this->table . " WHERE " . $column . " = :" . $column;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([$column => $value]);
        return $queryPrepared->fetchColumn();
    }

    public function getList(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $params = [];

        if (!empty($filters)) {
            $sql .= " WHERE ";
            foreach ($filters as $column => $value) {
                $sql .= " $column = :$column AND";
                $params[":$column"] = $value;
            }
            $sql = rtrim($sql, 'AND');
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        $queryPrepared = $this->pdo->prepare($sql);
        foreach ($params as $param => &$val) {
            if (is_int($val)) {
                $paramType = \PDO::PARAM_INT;
            } elseif (is_bool($val)) {
                $paramType = \PDO::PARAM_BOOL;
            } else {
                $paramType = \PDO::PARAM_STR;
            }
            $queryPrepared->bindParam($param, $val, $paramType);
        }

        $queryPrepared->execute();
        return $queryPrepared->fetchAll();
    }

    

    public function findAllBy(array $filters = [])
    {
        $sql = "SELECT * FROM " . $this->table;
        $params = [];

        if (!empty($filters)) {
            $sql .= " WHERE ";
            foreach ($filters as $column => $value) {
                $sql .= " $column = :$column AND";
                $params[":$column"] = $value;
            }
            $sql = rtrim($sql, 'AND');
        }

        $queryPrepared = $this->pdo->prepare($sql);
        foreach ($params as $param => &$val) {
            if (is_int($val)) {
                $paramType = \PDO::PARAM_INT;
            } elseif (is_bool($val)) {
                $paramType = \PDO::PARAM_BOOL;
            } else {
                $paramType = \PDO::PARAM_STR;
            }
            $queryPrepared->bindParam($param, $val, $paramType);
        }

        $queryPrepared->execute();
        return $queryPrepared->fetchAll();
    }

}
