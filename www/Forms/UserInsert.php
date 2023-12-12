<?php
namespace App\Forms;
use App\Core\BuildForm;

class UserInsert 
{

    public function getConfig(): array
    {
        return [
            "config"=> [
                        "method"=>"POST",
                        "action"=>"",
                        "submit"=>"S'inscrire",
                        "class"=>"form"
                     ],
            "inputs"=>[
                "Prénom"=>["type"=>"text", "class"=>"input-form" , "placeholder"=>"prénom", "minlen"=>2, "required"=>true, "error"=>"Le prénom doit faire plus de 2 caractères"],
                "Nom"=>["type"=>"text", "class"=>"input-form", "placeholder"=>"nom", "minlen"=>2, "required"=>true, "error"=>"Le nom doit faire plus de 2 caractères"],
                "E-mail"=>["type"=>"email", "class"=>"input-form", "placeholder"=>"email", "required"=>true, "error"=>"Le format de l'email est incorrect"],
                "Mot de passe"=>["type"=>"password", "class"=>"input-form", "placeholder"=>"mot de passe", "required"=>true, "error"=>"Votre mot de passe doit faire plus de 8 caractères avec minuscule et chiffre"],
                "Confirmation du Mot de passe"=>["type"=>"password", "class"=>"input-form", "confirm"=>"pwd" ,"placeholder"=>"confirmation", "required"=>true, "error"=>"Votre mot de passe de confirmation ne correspond pas"],
            ]
        ];
    }
    public function render(){
        $formGenerator = new BuildForm($this->getConfig());
        echo $formGenerator->generateForm();
    }

}