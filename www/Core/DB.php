<?php

namespace App\Core;

class DB
{
    private ?object $pdo = null;
    private string $table;

    public function __construct()
    {
        //connexion à la bdd via pdo
        try {
            $this->pdo = new \PDO('pgsql:host=172.24.0.2;dbname=easyCook;user=' . $_ENV["DB_USER"] . ';password=' . $_ENV["DB_PASSWORD"]);
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
        var_dump($data);
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
        return $queryPrepared->execute($data);
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
    public function getList(array $filters = [], int $limit, int $offset): array
    {
        $sql = "SELECT * FROM " . $this->table;
        if (!empty($filters)) {
            $sql .= " WHERE ";
            foreach ($filters as $column => $value) {
                $sql .= " " . $column . "=:" . $column . " AND";
            }
            $sql = substr($sql, 0, -3);
        }
        $sql .= " LIMIT :limit OFFSET :offset";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(":limit", $limit, \PDO::PARAM_INT);
        $queryPrepared->bindParam(":offset", $offset, \PDO::PARAM_INT);
        $queryPrepared->execute($filters);
        return $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }
}
