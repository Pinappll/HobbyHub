<section class="section">

    <h1>Users</h1>
    <br>
    <!-- <a href="/admin/users/add" class="button button-primary">Ajouter un utilisateur</a> -->
    <br>
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    
</section>