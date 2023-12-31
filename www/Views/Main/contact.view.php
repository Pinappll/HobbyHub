<?php
use App\Core\BuildForm;
use App\Forms\Contact;

?>


    <div class="container">
        <section>
        <h2>Remplissez le formulaire ci-dessous pour nous contacter</h2>
        </section>
        
        <?php

        $userForm = new Contact();
        $userForm->render();

        ?>
        
    </div>