<section class="section">

    <h1>Footer</h1>
    <br>
    <br>
    <?php
    // Vérifie si $configForm est bien défini avant d'inclure le formulaire
    if (isset($configForm)) {
        $this->includeComponent("form", $configForm, $errorsForm ?? []);
    } else {
        echo "<p>Le formulaire n'a pas pu être chargé.</p>";
    }

    // Afficher un message s'il existe
    if (isset($this->data["message"])) {
        echo "<h3>" . htmlspecialchars($this->data["message"]) . "</h3>";
    }
    ?>
    
</section>
