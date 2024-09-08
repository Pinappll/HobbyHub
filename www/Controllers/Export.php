<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\ExportForm;

class Export
{
    public function export(): void
    {
        $myView = new View("Admin/export", "back");
        $form = new ExportForm();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    private function addFilesToZip($directory, $zip, $relativePath = '')
{
    // Ouvrir le répertoire
    $dir = opendir($directory);

    // Parcourir chaque fichier et dossier du répertoire
    while ($file = readdir($dir)) {
        // Ignorer les dossiers spéciaux "." et ".."
        if ($file == '.' || $file == '..') {
            continue;
        }

        // Chemin complet du fichier/dossier
        $fullPath = $directory . '/' . $file;

        // Chemin relatif à ajouter dans le ZIP
        $relativeFilePath = $relativePath . $file;

        // Si c'est un répertoire, on l'ajoute et on appelle récursivement
        if (is_dir($fullPath)) {
            $zip->addEmptyDir($relativeFilePath); // Ajouter un répertoire vide dans le ZIP
            $this->addFilesToZip($fullPath, $zip, $relativeFilePath . '/'); // Appel récursif
        } else {
            // Si c'est un fichier, on l'ajoute dans le ZIP
            $zip->addFile($fullPath, $relativeFilePath);
        }
    }

    // Fermer le répertoire après traitement
    closedir($dir);
}


public function exportAction(): void
{
    include __DIR__ . '/../config.php'; // Inclure le fichier de configuration

    $zipFileName = 'solution_export_' . date('Y-m-d') . '.zip';
    $projectDirectory = __DIR__ . '/../../'; // Chemin vers la racine du projet
    $dbDumpFile = '/tmp/db_dump.sql'; // Fichier SQL généré
    $message = "";

    // Exécuter la commande pg_dump pour créer le fichier SQL
    $dumpCommand = "PGPASSWORD={$dbPassword} pg_dump --dbname=postgresql://{$dbUser}@{$dbHost}/{$dbName} > {$dbDumpFile}";
    exec($dumpCommand, $output, $returnVar);

    if ($returnVar !== 0) {
        $message = 'Erreur lors de l\'export de la base de données.';
    } else {
        $zip = new \ZipArchive();

        if ($zip->open($zipFileName, \ZipArchive::CREATE) !== true) {
            $message = 'Impossible de créer l\'archive ZIP.';
        } else {
            // Ajouter le fichier de dump SQL à l'archive ZIP
            $zip->addFile($dbDumpFile, 'db_dump.sql');

            // Ajouter tous les fichiers du projet à l'archive ZIP
            $this->addFilesToZip($projectDirectory, $zip);

            // Fermer l'archive ZIP
            $zip->close();

            // Forcer le téléchargement de l'archive ZIP
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
            header('Content-Length: ' . filesize($zipFileName));
            readfile($zipFileName);

            // Supprimer l'archive ZIP après téléchargement
            unlink($zipFileName);
        }
    }

    // Retourner un message si nécessaire
    $form = new ExportForm();
    $config = $form->getConfig();
    $myView = new View("Admin/export", "back");
    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", []);
    $myView->assign("message", $message);
}


}
