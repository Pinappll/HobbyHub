<section class="section">

    <h1>Recettes édition</h1>
    <br>
    <a href="/admin/recipes/add" class="button button-primary">Ajouter</a>
    <br>
    <br>
    <?php $this->includeComponent("form", $configForm, $errorsForm); ?>
    <?php
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>