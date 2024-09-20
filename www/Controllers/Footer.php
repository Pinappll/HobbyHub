<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\FooterUpdate;
use App\Core\Verificator;
use App\Models\Setting as SettingModel;

class Footer
{
    public function footer(): void
{
    $myView = new View("Admin/footer", "back");
    $form = new FooterUpdate();
    $config = $form->getConfig();

    // Récupérer les données actuelles de la table setting
    $settingModel = new SettingModel();
    $currentSetting = $settingModel->getOneBy(["id" => 1]); // Par exemple, récupérer le paramètre de l'ID 1

    // Si des paramètres existent, remplir le formulaire avec les données
    if ($currentSetting) {
        $config["inputs"]["name_setting"]["value"] = $currentSetting['name_setting'];
        $config["inputs"]["slogan_setting"]["value"] = $currentSetting['slogan_setting'];
        $config["inputs"]["link_facebook_setting"]["value"] = $currentSetting['link_facebook_setting'];
        $config["inputs"]["link_twitter_setting"]["value"] = $currentSetting['link_twitter_setting'];
        $config["inputs"]["link_instagram_setting"]["value"] = $currentSetting['link_instagram_setting'];
    }

    // Assigner le formulaire configuré à la vue
    $myView->assign("configForm", $config);
    $myView->assign("title", "Paramètres du footer");
}


    public function update(): void
    {
        $myView = new View("Admin/footer", "back");
        $form = new FooterUpdate();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        $footer = new SettingModel();
        $currentSetting = $footer->getOneBy(["id" => 1], "object");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();

            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $currentSetting->setName_setting($_REQUEST["name_setting"]);
                $currentSetting->setSlogan_setting($_REQUEST["slogan_setting"]);
                $currentSetting->setLink_facebook_setting($_REQUEST["link_facebook_setting"]);
                $currentSetting->setLink_twitter_setting($_REQUEST["link_twitter_setting"]);
                $currentSetting->setLink_instagram_setting($_REQUEST["link_instagram_setting"]);
                $result = $currentSetting->save();

                if ($result) {
                    $message = "Footer mis à jour avec succès.";
                } else {
                    $errors[] = "Erreur lors de la mise à jour du footer.";
                }
            }
            
        }

        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }
}