<?php

namespace App\Core;
use PDO;
class DB
{
    protected ?object $pdo = null;
    private static ?\PDO $instance = null; 
    protected string $table;
    protected string $query;
    protected string $dbName;

    public function __construct()
{
    // connexion à la bdd via pdo
    include 'config.php';  // Configuration de la base de données (doit définir $dbHost, $dbName, $dbUser, $dbPassword)
    try {
        $this->pdo = new \PDO('pgsql:host=' . $dbHost . ';dbname=' . $dbName . ';user=' . $dbUser . ';password=' . $dbPassword);
    } catch (\PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

    // Obtenir le nom de la table dynamiquement : "dbnam_settings" où "dbnam" est le nom de la base de données
    $table = get_called_class();
    $table = explode("\\", $table);
    $table = array_pop($table);
    
    // Créer le nom de la table en fonction du nom de la base de données et du modèle
    $this->table = strtolower($dbName) . "_" . strtolower($table);
    $this->dbName = $dbName;
}

    
    public static function getPDO(): ?\PDO
    {
        if (self::$instance === null) {
            include 'config.php';
            try {
                self::$instance = new \PDO('pgsql:host=' . $dbHost . ';dbname=' . $dbName . ';user=' . $dbUser . ';password=' . $dbPassword);
            } catch (\PDOException $e) {
                echo "Erreur SQL : " . $e->getMessage();
            }
        }
        return self::$instance;
    }

    public function getDataObject(): array
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    public function save()
{
    $data = $this->getDataObject();
    
    // Détecter si c'est un INSERT ou un UPDATE
    if (empty($this->getId())) {
        // Construction de la requête d'insertion
        $sql = "INSERT INTO " . $this->table . "(" . implode(",", array_keys($data)) . ") 
                VALUES (:" . implode(",:", array_keys($data)) . ")";
    } else {
        // Construction de la requête de mise à jour
        $sql = "UPDATE " . $this->table . " SET ";
        foreach ($data as $column => $value) {
            $sql .= $column . "=:" . $column . ",";
        }
        
        // Enlever la dernière virgule
        $sql = rtrim($sql, ',');
        $sql .= " WHERE id = " . $this->getId();
    }

    // Préparation de la requête
    $queryPrepared = $this->pdo->prepare($sql);
    
    // Conversion correcte des booléens pour PostgreSQL (utilisation directe de booléens)
    foreach ($data as $key => $value) {
        if (is_bool($value)) {
            // PostgreSQL attend des booléens directs, donc on ne touche pas à la valeur
            $queryPrepared->bindValue(':' . $key, $value, \PDO::PARAM_BOOL);
        } else {
            $queryPrepared->bindValue(':' . $key, $value);
        }
    }
    
    // Exécuter la requête
    $success = $queryPrepared->execute();

    // Si c'est un INSERT, récupérer l'ID
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
    // Construction de la requête SQL
    $sql = "SELECT * FROM " . $this->table . " WHERE ";
    foreach ($data as $column => $value) {
        $sql .= " " . $column . "=:" . $column . " AND";
    }
    $sql = rtrim($sql, ' AND');  // Supprimer le dernier 'AND'

    // Préparation de la requête
    $queryPrepared = $this->pdo->prepare($sql);
    
    // Liaison des valeurs en tenant compte des booléens
    foreach ($data as $key => $value) {
        if (is_bool($value)) {
            $queryPrepared->bindValue(':' . $key, $value, PDO::PARAM_BOOL);
        } else {
            $queryPrepared->bindValue(':' . $key, $value);
        }
    }

    // Exécution de la requête
    $queryPrepared->execute();

    // Définition du mode de récupération
    if ($return === "object") {
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
    } else {
        $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
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



    public function findAllBy(array $filters = [], $return = "array")
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
        if ($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        }
        $queryPrepared->execute();
        return $queryPrepared->fetchAll();
    }
    public function select($columns = '*')
    {
        $this->query = "SELECT $columns FROM $this->table";
        return $this;
    }

    public function join($table, $on)
    {
        $this->query .= " JOIN $table ON $on";
        return $this;
    }

    public function where($conditions)
    {
        $this->query .= " WHERE $conditions";
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->query .= " ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit)
    {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
    public function execute(string $return = "array")
    {
        $queryPrepared = $this->pdo->prepare($this->query);
        if ($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        }
        $queryPrepared->execute();
        return $queryPrepared->fetchAll();
    }
    public function from()
    {
        $this->table;
        return $this;
    }
    public function getNameDb()
    {
        return $this->dbName;
    }
    public function executeWithParams(array $params = [], string $return = "array")
{
    $queryPrepared = $this->pdo->prepare($this->query);
    
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

    if ($return == "object") {
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
    }
    
    $queryPrepared->execute();
    return $queryPrepared->fetchAll();
}


    public function getTable()
    {
        return $this->table;
    }

    public function getCountByMonth(string $dateColumn = 'inserted_at'): array
{
    // La requête SQL pour compter les enregistrements par mois, en tronquant la date au mois
    $sql = "SELECT DATE_TRUNC('month', $dateColumn) AS month, COUNT(*) AS count 
            FROM " . $this->table . " 
            GROUP BY month 
            ORDER BY month ASC";

    // Préparation et exécution de la requête
    $queryPrepared = $this->pdo->prepare($sql);
    $queryPrepared->execute();

    // Récupérer les résultats
    return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
}
public function findBy(array $filters = []): array
{
    $sql = "SELECT * FROM " . $this->table;
    $params = [];

    if (!empty($filters)) {
        $sql .= " WHERE ";
        foreach ($filters as $column => $value) {
            $sql .= "$column = :$column AND ";
            $params[":$column"] = $value;
        }
        $sql = rtrim($sql, ' AND ');
    }

    $queryPrepared = $this->pdo->prepare($sql);
    $queryPrepared->execute($params);
    return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC); // Renvoie un tableau associatif
}
public function query(string $sql)
{
    return $this->pdo->query($sql);
}

}
