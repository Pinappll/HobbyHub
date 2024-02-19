<section class="section">

    <h1>Navigation</h1>
    <br>
    <a href="/admin/navigation/add" class="button button-primary">Ajouter</a>
    <br>
    <br><?php $this->includeComponent("form", $configForm, $errorsForm); ?>
    <?php
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>