<section class="section">

    <h1>Pages</h1>
    <br>
    <a href="/admin/pages/add-page" class="button button-primary">Ajouter une page</a>
    <br>
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    
</section>