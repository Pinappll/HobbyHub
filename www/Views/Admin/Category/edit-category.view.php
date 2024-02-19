<section class="section">

    <h1>Catégories</h1>
    <br>
    <a href="/admin/category" class="button button-primary">Retour</a>
    <br>
    <br>
    <?php $this->includeComponent("form", $configForm, $errorsForm);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>