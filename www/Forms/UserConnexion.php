<?php
namespace App\Forms;
use App\Core\BuildForm;

class UserConnexion 
{

    public function getConfig(): array
    {
        return [
            "config"=> [
                        "method"=>"POST",
                        "action"=>"",
                        "submit"=>"Se connecter",
                        "class"=>"form"
                     ],
            "inputs"=>[
                "E-mail"=>["type"=>"email", "class"=>"input-form", "placeholder"=>"email", "required"=>true, "error"=>"Le format de l'email est incorrect"],
                "Mot de passe"=>["type"=>"password", "class"=>"input-form", "placeholder"=>"mot de passe", "required"=>true, "error"=>"Votre mot de passe doit faire plus de 8 caractères avec minuscule et chiffre"],
            ]
        ];
    }
    public function render(){
        $formGenerator = new BuildForm($this->getConfig());
        echo $formGenerator->generateForm();
    }

}