<?php

namespace App\Controllers;

use App\Models\Navigation;

class SitemapController
{
    public function generateSitemap()
    {
        // Créer un nouvel objet de Navigation pour accéder aux données
        $navigation = new Navigation();

        // Récupérer tous les liens de navigation
        $links = $navigation->getAll(); 

        // Générer le sitemap XML
        $sitemap = new \SimpleXMLElement('<urlset/>');
        $sitemap->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        // Accueil
        $url = $sitemap->addChild('url');
        $url->addChild('loc', 'http://www.easycook.ninja/'); // Ajoutez ici votre URL de base
        $url->addChild('lastmod', date('Y-m-d')); // Vous pouvez personnaliser ceci avec la date réelle de mise à jour
        $url->addChild('priority', '1.0'); // Ajustez la priorité si nécessaire

        // Contact
        $url = $sitemap->addChild('url');
        $url->addChild('loc', 'http://www.easycook.ninja/contact'); // Ajoutez ici votre URL de base
        $url->addChild('lastmod', date('Y-m-d')); // Vous pouvez personnaliser ceci avec la date réelle de mise à jour
        $url->addChild('priority', '0.9'); // Ajustez la priorité si nécessaire

        // design guide
        $url = $sitemap->addChild('url');
        $url->addChild('loc', 'http://www.easycook.ninja/design-guide'); // Ajoutez ici votre URL de base
        $url->addChild('lastmod', date('Y-m-d')); // Vous pouvez personnaliser ceci avec la date réelle de mise à jour
        $url->addChild('priority', '0.9'); // Ajustez la priorité si nécessaire


        foreach ($links as $link) {
            $url = $sitemap->addChild('url');
            $url->addChild('loc', 'http://www.easycook.ninja' . $link->getLink()); // Ajoutez ici votre URL de base
            $url->addChild('lastmod', date('Y-m-d')); // Vous pouvez personnaliser ceci avec la date réelle de mise à jour
            $url->addChild('priority', '0.8'); // Ajustez la priorité si nécessaire
        }

        // Sauvegarder ou afficher le sitemap
        header('Content-Type: application/xml');
        echo $sitemap->asXML();
    }
}
