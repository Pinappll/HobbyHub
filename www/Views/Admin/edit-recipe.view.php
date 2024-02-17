Formulaire pour
<?php $this->includeComponent("form", $configForm, $errorsForm); ?>
<?php
if (isset($this->data["message"])) {
    echo "<h3>" . $this->data["message"] . "</h3>";
}
?>