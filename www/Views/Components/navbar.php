<?php 

use App\Models\Navigation;


$menuItem = new Navigation();
$config = $menuItem->getList();

function displayMenu($config)
{
    foreach ($config as $key => $value) {
        if ($value["parent_id"] == 0) {
            
            echo "<li><a href='" . $value["link"] . "'>" . $value["name"] . "</a>";
            displaySubMenu($config, $value["id"]);
            echo "</li>";
        }
    }
}

function displaySubMenu($config, $id)
{
    $hasSubmenu = false;
    foreach ($config as $key => $value) {
        if ($value["parent_id"] == $id) {
            if ($hasSubmenu === false) {
                echo "<ul class='dropdown dropdown-content'>";
                $hasSubmenu = true;
            }
            echo "<li><a  href='" . $value["link"] . "'>" . $value["name"] . "</a>";
            displaySubMenu($config, $value["id"]);
            echo "</li>";
        }
    }
    if ($hasSubmenu === true) {
        echo "</ul>";
    }
}

displayMenu($config);



?>
