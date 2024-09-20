<section class="section">
<h1>Users</h1>
    <br>
    <a href="/admin/users/add" class="button button-primary">Ajouter un utilisateur</a>
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
