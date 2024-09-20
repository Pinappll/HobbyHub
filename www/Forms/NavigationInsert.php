<?php

namespace App\Forms;

use App\Models\Navigation as NavigationModel;

class NavigationInsert
{
    public function getConfig(array $data = []): array
    {
        $parents = $data['parents'] ?? [];
        $nextPosition = $data['nextPosition'] ?? 1;
        $selectedPosition = $data['selectedPosition'] ?? null;
        $selectedParent = $data['selectedParent'] ?? null;
        $isInNavbar = $data['is_in_navbar'] ?? 0; // Valeur par défaut pour is_in_navbar

        // Générer les options pour les positions existantes, les ordonner et ajouter la prochaine position
        $positionOptions = [];
        $positionsInNavbar = array_unique($data['positionsInNavbar'] ?? []); // Assurer que les positions sont uniques
        sort($positionsInNavbar); // Ordonner les positions

        foreach ($positionsInNavbar as $position) {
            $positionOptions[] = [
                "value" => $position,
                "label" => "Position " . $position,
                "selected" => ($position == $selectedPosition)
            ];
        }

        // Ajouter l'option pour la prochaine position disponible
        $positionOptions[] = [
            "value" => $nextPosition,
            "label" => "Prochaine position " . $nextPosition,
            "selected" => ($nextPosition == $selectedPosition)
        ];

        // Générer les options pour les parents présents dans la navbar
        $parentOptions = [["value" => 0, "label" => "Aucun parent", "selected" => ($selectedParent === null || $selectedParent == 0)]];

        foreach ($parents as $parent) {
            $parentOptions[] = [
                "value" => $parent['id'] ?? '',
                "label" => $parent['name'] ?? '',
                "selected" => ($parent['id'] == $selectedParent)
            ];
        }

        // Retourner la configuration du formulaire
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/navigation/add",
                "submit" => "Ajouter",
                "class" => "form",
                "id" => "form-navigation-insert",
            ],
            "inputs" => [
                "name" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom",
                    "required" => true,
                    "error" => "Votre nom doit faire plus de 2 caractères",
                    "value" => $data['name'] ?? ''
                ],
                "position" => [
                    "type" => "select",
                    "class" => "input-form",
                    "placeholder" => "Position",
                    "required" => true,
                    "error" => "Veuillez sélectionner une position valide",
                    "options" => $positionOptions
                ],
                "parent_id" => [
                    "type" => "select",
                    "class" => "input-form",
                    "placeholder" => "Parent",
                    "required" => false,
                    "error" => "Veuillez sélectionner une navigation parent valide",
                    "options" => $parentOptions
                ],
                "level" => [
                    "type" => "number",
                    "class" => "input-form",
                    "placeholder" => "Niveau",
                    "required" => true,
                    "error" => "Votre niveau doit être un nombre",
                    "value" => $data['level'] ?? 1
                ],
                "is_in_navbar" => [
                    "type" => "select",
                    "class" => "input-form",
                    "placeholder" => "Afficher dans la navbar",
                    "required" => true,
                    "options" => [
                        ["value" => 1, "label" => "Oui", "selected" => ($isInNavbar == 1)],
                        ["value" => 0, "label" => "Non", "selected" => ($isInNavbar == 0)]
                    ],
                    "error" => "Veuillez choisir si la navigation doit apparaître dans la navbar."
                ]
            ]
        ];
    }
}
