<section class="section">

    <h1>Commentaires</h1>
    
    <br>
    <?php $this->includeComponent("table", $configTable, $data);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    
</section>