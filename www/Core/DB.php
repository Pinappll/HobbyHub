<?php

namespace App\Core;

class DB
{
    protected ?object $pdo = null;
    private static ?\PDO $instance = null; 
    private string $table;
    protected string $dbName;

    public function __construct()
    {
        // Connexion à la base de données via PDO
        include 'config.php';
        try {
            $this->pdo = new \PDO('pgsql:host=' . $dbHost . ';dbname=' . $dbName . ';user=' . $dbUser . ';password=' . $dbPassword);
        } catch (\PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }

        // Détermination du nom de la table à partir du nom de la classe appelante
        $table = get_called_class();
        $table = explode("\\", $table);
        $table = array_pop($table);
        $this->dbName = strtolower($dbName);
        $this->table = $dbName . "_" . strtolower($table);
    }

    public static function getTable(): string
    {
        include 'config.php';
        $table = get_called_class();
        $table = explode("\\", $table);
        $table = array_pop($table);
        return $dbName . "_" . strtolower($table);
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

    // Récupère toutes les données sous forme d'un tableau associatif
    public function getDataObject(): array
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    // Sauvegarde ou met à jour un enregistrement
    public function save()
    {
        $data = $this->getDataObject();

        if (empty($this->getId())) {
            // Requête d'insertion
            $sql = "INSERT INTO " . $this->table . "(" . implode(",", array_keys($data)) . ") 
            VALUES (:" . implode(",:", array_keys($data)) . ")";
        } else {
            // Requête de mise à jour
            $sql = "UPDATE " . $this->table . " SET ";
            foreach ($data as $column => $value) {
                $sql .= $column . "=:" . $column . ",";
            }
            $sql = rtrim($sql, ',');
            $sql .= " WHERE id = " . $this->getId();
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $success = $queryPrepared->execute($data);

        if (empty($this->getId())) {
            $lastInsertId = $this->pdo->lastInsertId();
            $this->setId($lastInsertId);
        }

        return $success;
    }

    // Récupère tous les enregistrements
    public function findAll(): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    // Récupère un enregistrement par ID
    public static function populate(int $id): object
    {
        $class = get_called_class();
        $object = new $class();
        return $object->getOneBy(["id" => $id], "object");
    }

    // Récupère un enregistrement par un critère spécifique
    public function getOneBy(array $data, string $return = "array")
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE ";
        foreach ($data as $column => $value) {
            $sql .= $column . "=:" . $column . " AND ";
        }
        $sql = rtrim($sql, "AND ");
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);

        if ($return == "object") {
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        }

        return $queryPrepared->fetch();
    }

    // Supprime un enregistrement par ID
    public function delete()
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $this->getId();
        $queryPrepared = $this->pdo->prepare($sql);
        return $queryPrepared->execute();
    }

    // Compte le nombre total de lignes dans la table
    public function countRows(): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchColumn();
    }

    // Récupère une colonne spécifique dans la table
    public function getColumns(string $column): array
    {
        $sql = "SELECT " . $column . " FROM " . $this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_COLUMN);
    }

    // Récupère un ID basé sur une colonne spécifique
    public function getIdFromTable(string $column, string $value): int
    {
        $sql = "SELECT id FROM " . $this->table . " WHERE " . $column . " = :" . $column;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([$column => $value]);
        return $queryPrepared->fetchColumn();
    }

    // Filtrage simple pour récupérer une liste avec limite et offset
    public function getList(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $params = [];
        $types = []; // Pour stocker les types des paramètres
    
        if (!empty($filters)) {
            $sql .= " WHERE ";
            foreach ($filters as $column => $value) {
                // Convertir les valeurs booléennes en int pour la base de données
                if (is_bool($value)) {
                    $value = $value ? 1 : 0;
                }
                $sql .= "$column = :$column AND ";
                $params[":$column"] = $value;
    
                // Déterminer le type de paramètre en fonction du type de valeur
                $types[":$column"] = \PDO::PARAM_INT; // Utilisez PDO::PARAM_STR si la colonne est de type string
            }
            $sql = rtrim($sql, "AND ");
        }
    
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
    
        $queryPrepared = $this->pdo->prepare($sql);
    
        // Lier les paramètres avec les types appropriés
        foreach ($params as $param => $value) {
            $type = $types[$param] ?? \PDO::PARAM_STR; // Par défaut, utilisez PDO::PARAM_STR
            $queryPrepared->bindValue($param, $value, $type);
        }
    
        $queryPrepared->execute();
        
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function findAllBy(array $filters = [], $return = "array")
{
    $sql = "SELECT * FROM " . $this->table;
    $params = [];

    if (!empty($filters)) {
        $sql .= " WHERE ";
        foreach ($filters as $column => $value) {
            // Utiliser LIKE si la valeur contient %
            if (strpos($value, '%') !== false) {
                $sql .= "$column LIKE :$column AND ";
            } else {
                $sql .= "$column = :$column AND ";
            }
            $params[":$column"] = $value;
        }
        $sql = rtrim($sql, "AND ");
    }

    $queryPrepared = $this->pdo->prepare($sql);
    $queryPrepared->execute($params);

    if ($return == "object") {
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
    }

    return $queryPrepared->fetchAll();
}
}
