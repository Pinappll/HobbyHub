<div class="container">
<section class="section">

    <h1>Formulaire de changement de mot de passe</h1>
    <br>
    <br>
<?php $this->includeComponent("form", $configForm, $errorsForm); ?>
<?php
if (isset($this->data["message"])) {
    echo "<h3>" . $this->data["message"] . "</h3>";
}
?>

</section>

</div>