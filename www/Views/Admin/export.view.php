<section class="section">

    <h1>Export</h1>
    <br>
    
    <?php
    // Inclure le formulaire
    $this->includeComponent("form", $configForm, $errorsForm);

    // Afficher un message de succès si l'exportation a réussi
    if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <h3 class="message">L'exportation a été réalisée avec succès.</h3>
    <?php endif; ?>

    <?php
    // Afficher un autre message s'il existe et n'est pas vide
    if (isset($this->data["message"]) && !empty($this->data["message"])): ?>
        <h3 class="message"><?php echo htmlspecialchars($this->data["message"]); ?></h3>
    <?php endif; ?>

</section>
