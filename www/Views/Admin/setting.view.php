<section class="section">

    <h1>Settings</h1>
    <br>
    <br>
    <?php
    // Inclure le formulaire
    $this->includeComponent("form", $configForm, $errorsForm ?? []);
    // Afficher un message s'il existe
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
</section>
