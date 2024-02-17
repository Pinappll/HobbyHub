<section class="section">

    <h1>Navigation</h1>
    <br>
    <?php $this->includeComponent("form", $configForm, $errorsForm);
    if (isset($this->data["message"])) {
        echo "<h3>" . $this->data["message"] . "</h3>";
    }
    ?>

</section>