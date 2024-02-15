Formulaire de connexion
<?php $this->includeComponent("table", $configTable, $data);
if (isset($this->data["message"])) {
    echo "<h3>" . $this->data["message"] . "</h3>";
}
?>