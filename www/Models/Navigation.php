<?php

namespace App\Models;

use App\Core\DB;

class Navigation extends DB
{
    private ?int $id = null;
    protected string $name;
    protected string $link;
    protected int $position;
    protected ?int $parent_id = null; // Peut être null si pas de parent
    protected int $level;
    protected int $id_page;
    protected int $is_in_navbar; // Change de boolean à int

    public function __construct()
    {
        parent::__construct();
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getIdPage(): int
    {
        return $this->id_page;
    }

    public function setIdPage(int $id_page): self
    {
        $this->id_page = $id_page;
        return $this;
    }

    // Nouveau getter et setter pour is_in_navbar
    public function getIsInNavbar(): int
    {
        return $this->is_in_navbar;
    }

    public function setIsInNavbar(int $isInNavbar): self
    {
        $this->is_in_navbar = $isInNavbar;
        return $this;
    }


    /**
     * Récupérer toutes les navigations
     */
    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getParentNavigations(): array
{
    // Récupérer toutes les navigations qui n'ont pas de parent (parent_id est NULL) et qui sont dans la navbar
    $sql = "SELECT id, name FROM " . $this->table . " WHERE parent_id IS NULL AND is_in_navbar = 1";
    $query = $this->getPDO()->prepare($sql);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_ASSOC);
}


    /**
     * Récupérer toutes les sous-navigations pour une navigation donnée
     */
    public function getChildNavigations(int $parentId): array
    {
        return $this->findBy(['parent_id' => $parentId]);
    }

    /**
     * Récupérer la prochaine position disponible
     */
    public function getNextPosition(): int
    {
        $sql = "SELECT MAX(position) as max_position FROM " . $this->table;
        $result = $this->getPDO()->query($sql)->fetch();
        return ($result && $result['max_position']) ? $result['max_position'] + 1 : 1;
    }

    /**
     * Récupérer une navigation spécifique par ID
     */
    public function getNavigationById(int $id): ?self
    {
        $navigationData = $this->getOneBy(['id' => $id], "array");
        if ($navigationData) {
            return $this->hydrate($navigationData);
        }
        return null;
    }

    /**
     * Hydrate l'objet navigation à partir des données d'une ligne de la base de données
     */
    private function hydrate(array $data): self
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->link = $data['link'];
        $this->position = $data['position'];
        $this->parent_id = $data['parent_id'] ?? null;
        $this->level = $data['level'];
        $this->id_page = $data['id_page'];
        $this->is_in_navbar = $data['is_in_navbar'] ?? false; // Hydrater le champ is_in_navbar
        return $this;
    }

    /**
     * Récupérer toutes les positions existantes dans la table navigation
     */
    public function getExistingPositions(): array
    {
        $sql = "SELECT position FROM " . $this->table . " ORDER BY position ASC";
        $query = $this->getPDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function save()
{
    $data = $this->getDataObject();

    // Forcer la conversion de is_in_navbar en entier avant la sauvegarde
    if (isset($data['is_in_navbar'])) {
        $data['is_in_navbar'] = (int)$data['is_in_navbar']; // Assurer que c'est un entier
    }

    // Si l'ID n'existe pas, on fait un INSERT
    if (empty($this->getId())) {
        $sql = "INSERT INTO " . $this->table . "(" . implode(",", array_keys($data)) . ") 
        VALUES (:" . implode(",:", array_keys($data)) . ")";
    } else {
        // Sinon, on fait un UPDATE
        $sql = "UPDATE " . $this->table . " SET ";
        foreach ($data as $column => $value) {
            $sql .= $column . "=:" . $column . ",";
        }
        $sql = substr($sql, 0, -1); // Retirer la dernière virgule
        $sql .= " WHERE id = :id"; // Mise à jour où l'ID correspond
        $data['id'] = $this->getId(); // Ajouter l'ID pour la condition WHERE
    }

    $queryPrepared = $this->pdo->prepare($sql);
    $success = $queryPrepared->execute($data);

    // Si c'est un INSERT, on récupère l'ID de la nouvelle ligne
    if (empty($this->getId())) {
        $lastInsertId = $this->pdo->lastInsertId();
        $this->setId($lastInsertId);
    }

    return $success;
}


    
/**
     * Récupérer les positions des éléments dans la navbar
     */
    public function getNavbarPositions(): array
{
    $sql = "SELECT position FROM " . $this->table . " WHERE is_in_navbar = 1 ORDER BY position ASC";
    $query = $this->getPDO()->prepare($sql);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_COLUMN);
}

    /**
     * Mettre à jour la position d'une navigation
     */
    public function updatePosition(int $newPosition, int $nextPosition): void
    {
        $sql = "UPDATE " . $this->table . " SET position = position + 1 WHERE position >= :newPosition";
        $queryPrepared = $this->getPDO()->prepare($sql);
        $queryPrepared->execute(['newPosition' => $newPosition]);
    }

    public function reorderPositions(): void
    {
        $sql = "SELECT id, position FROM " . $this->table . " ORDER BY position ASC";
        $navigations = $this->getPDO()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        $newPosition = 1;
        foreach ($navigations as $navigation) {
            if ($navigation['position'] != $newPosition) {
                $updateSql = "UPDATE " . $this->table . " SET position = :newPosition WHERE id = :id";
                $queryPrepared = $this->getPDO()->prepare($updateSql);
                $queryPrepared->execute(['newPosition' => $newPosition, 'id' => $navigation['id']]);
            }
            $newPosition++;
        }
    }

}
