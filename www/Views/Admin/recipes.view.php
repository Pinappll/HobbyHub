<section class="section">

    <h1>Recettes</h1>
    <br>
    <a href="/admin/recipes/add" class="button button-primary">Ajouter</a>
    <br>
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    
</section>