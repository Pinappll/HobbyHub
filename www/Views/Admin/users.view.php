<section class="section">
    <h1>Users</h1>
    <br>
    <br>
    <!-- Ajouter le conteneur table-container ici -->
    <div class="table-container">
        <?php $this->includeComponent("table", $configTable, $data); ?>
    </div>

    <?php 
    // Afficher le message s'il existe
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
</section>
