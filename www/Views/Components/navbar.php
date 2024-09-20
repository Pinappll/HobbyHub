<?php 

use App\Models\Navigation;

// Récupérer toutes les navigations
$menuItem = new Navigation();
$config = $menuItem->getList();

// Filtrer les navigations pour ne garder que celles cochées pour la navbar
$navbarItems = array_filter($config, function($item) {
    return $item['is_in_navbar']; // Filtrer sur le champ is_in_navbar
});

function displayMenu($config) {
    echo "<ul class='nav-menu'>"; // Ajout de la classe 'nav-menu' pour la liste principale
    foreach ($config as $key => $value) {
        if ($value["parent_id"] == 0) {
            echo "<li class='nav-item'><a class='nav-link' href='" . $value["link"] . "'>" . $value["name"] . "</a>";
            displaySubMenu($config, $value["id"]);
            echo "</li>";
        }
    }
    echo "</ul>";
}

function displaySubMenu($config, $id) {
    $hasSubmenu = false;
    foreach ($config as $key => $value) {
        if ($value["parent_id"] == $id) {
            if ($hasSubmenu === false) {
                echo "<ul class='dropdown-menu'>"; // Classe pour le sous-menu
                $hasSubmenu = true;
            }
            echo "<li class='dropdown-item'><a class='dropdown-link' href='" . $value["link"] . "'>" . $value["name"] . "</a>";
            displaySubMenu($config, $value["id"]);
            echo "</li>";
        }
    }
    if ($hasSubmenu === true) {
        echo "</ul>";
    }
}

// Afficher uniquement les éléments cochés (is_in_navbar = true)
displayMenu($navbarItems);

?>
