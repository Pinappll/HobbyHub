<?php

namespace App\Models;

use App\Core\DB;

class Setting extends DB
{
    private ?int $id = null;
    protected string $name_setting;
    protected string $slogan_setting;
    protected ?string $link_facebook_setting ;
    protected ?string $link_twitter_setting;
    protected ?string $link_instagram_setting;
    protected string $logo_url_setting;
    protected string $color_setting;

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString()
    {
        return $this->getName_setting();
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id): self

    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name_setting
     */

    public function getName_setting(): ?string

    {
        return $this->name_setting;
    }

    /**
     * Set the value of name_setting
     *
     * @return  self
     */

    public function setName_setting($name_setting): self

    {
        $this->name_setting = $name_setting;

        return $this;
    }

    /**
     * Get the value of slogan_setting
     */

    public function getSlogan_setting(): ?string

    {
        return $this->slogan_setting;
    }

    /**
     * Set the value of slogan_setting
     *
     * @return  self
     */

    public function setSlogan_setting($slogan_setting): self

    {
        $this->slogan_setting = $slogan_setting;

        return $this;
    }

    /**
     * Get the value of link_facebook_setting
     */

    public function getLink_facebook_setting(): ?string

    {
        return $this->link_facebook_setting;
    }

    /**
     * Set the value of link_facebook_setting
     *
     * @return  self
     */

    public function setLink_facebook_setting($link_facebook_setting): self

    {
        $this->link_facebook_setting = $link_facebook_setting;

        return $this;
    }

    /**
     * Get the value of link_twitter_setting
     */

    public function getLink_twitter_setting(): ?string

    {
        return $this->link_twitter_setting;
    }

    /**
     * Set the value of link_twitter_setting
     *
     * @return  self
     */

    public function setLink_twitter_setting($link_twitter_setting): self

    {
        $this->link_twitter_setting = $link_twitter_setting;

        return $this;
    }

    /**
     * Get the value of link_instagram_setting
     */

    public function getLink_instagram_setting(): ?string

    {
        return $this->link_instagram_setting;
    }

    /**
     * Set the value of link_instagram_setting
     *
     * @return  self
     */

    public function setLink_instagram_setting($link_instagram_setting): self

    {
        $this->link_instagram_setting = $link_instagram_setting;

        return $this;
    }

    /**
     * Get the value of logo_url_setting
     */

    public function getLogo_url_setting(): ?string

    {
        return $this->logo_url_setting;
    }

    /**
     * Set the value of logo_url_setting
     *
     * @return  self
     */

    public function setLogo_url_setting($logo_url_setting): self

    {
        $this->logo_url_setting = $logo_url_setting;

        return $this;
    }

    /**
     * Get the value of color_setting
     */

    public function getColor_setting(): ?string

    {
        return $this->color_setting;
    }

    /**
     * Set the value of color_setting
     *
     * @return  self
     */

    public function setColor_setting($color_setting): self

    {
        $this->color_setting = $color_setting;

        return $this;
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

public function getSiteName(): ?string
    {
        // Utiliser la méthode getColumns pour récupérer la colonne name_setting
        $names = $this->getColumns('name_setting');
        
        // Renvoyer le premier nom (il doit y avoir un seul enregistrement pour le nom du site)
        return !empty($names) ? $names[0] : null;
    }

    public function getSocialLinks(): array
    {
        $settings = $this->getOneBy(['id' => 1]); // On suppose que les réglages sont stockés dans l'ID 1

        return [
            'facebook' => $settings['link_facebook_setting'] ?? null,
            'instagram' => $settings['link_instagram_setting'] ?? null,
            'twitter' => $settings['link_twitter_setting'] ?? null,
        ];
    }


}
