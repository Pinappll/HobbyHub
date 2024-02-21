<section class="section">

    <h1>Catégories</h1>
    <br>
    <a href="/admin/category/add" class="button button-primary">Ajouter</a>
    <br>
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>