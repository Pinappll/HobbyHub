<section class="section">

    <h1>Menu</h1>
    <br>
    <a href="/admin/menus/add" class="button button-primary">Ajouter</a>
    <br>
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>