<section class="section">

    <h1>Users</h1>
    <br>
    <br>
    <?php $this->includeComponent("form", $configForm, $errorsForm);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>
    
</section>