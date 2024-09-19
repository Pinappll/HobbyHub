<?php

namespace App\Models;

use App\Core\DB;

class Setting extends DB
{
    private ?int $id = null;
    protected string $name_setting;
    protected string $slogan_setting;
    protected string $logo_url_setting;
    protected string $color_setting;

    public function __construct()
    {
        parent::__construct();
    }

    // Méthode pour récupérer les paramètres existants
    public function getSettings(): ?array
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = 1"; // Récupérer les paramètres globaux
        $queryPrepared = self::getPDO()->prepare($sql);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        return $result ?: []; // Retourner un tableau vide si aucun résultat
    }


    // Méthode pour mettre à jour les paramètres (couleurs, logo, etc.)
    public function updateSettings(array $settings): bool
{
    // Construire la requête d'UPDATE avec les paramètres fournis
    $sql = "UPDATE " . $this->table . " SET 
                name_setting = :name_setting, 
                slogan_setting = :slogan_setting, 
                logo_url_setting = :logo_url_setting, 
                color_setting = :color_setting
            WHERE id = 1";  // Supposons que les paramètres globaux sont dans l'enregistrement id=1

    $queryPrepared = self::getPDO()->prepare($sql);

    // Préparer les paramètres pour la mise à jour
    $params = [
        ':name_setting' => $settings['name_setting'] ?? '',
        ':slogan_setting' => $settings['slogan_setting'] ?? '',
        ':logo_url_setting' => $settings['logo_url_setting'] ?? '',
        ':color_setting' => $settings['color_setting'] ?? ''
    ];

    return $queryPrepared->execute($params);
}


}
