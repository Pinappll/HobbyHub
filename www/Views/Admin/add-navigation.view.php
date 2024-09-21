<section class="section">

    <h1>Ajout navigation</h1>
    <br>
    <a href="/admin/navigation" class="button button-primary">Retour</a>
    <br>
    <br>
<?php 
if (isset($configForm) && isset($errorsForm)) {
    // Inclusion du composant avec les valeurs pré-remplies
    $this->includeComponent("form", $configForm, $errorsForm);
} else {
    echo "<p>Le formulaire n'est pas disponible pour le moment.</p>";
}

// Affichage des erreurs s'il y en a
if (!empty($errorsForm)) {
    echo "<div class='errors'>";
    foreach ($errorsForm as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
    echo "</div>";
}

?>

