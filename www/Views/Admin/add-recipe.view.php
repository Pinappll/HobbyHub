<section class="section">

    <h1>Ajout recettes</h1>
    <br>
    <a href="/admin/recipes" class="button button-primary">Retour</a>
    <br>
    <br><?php $this->includeComponent("form", $configForm, $errorsForm);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    <div id="content-recipe">

    </div>
</section >