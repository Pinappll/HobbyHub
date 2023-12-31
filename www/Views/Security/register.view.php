<?php
use App\Core\BuildForm;
use App\Forms\UserInsert;

?>


    <div class="container">
        <section>
        <h2>Inscription</h2>
        <p>Remplissez le formulaire ci-dessous pour créer votre compte.</p>
        </section>
        
        <?php

        $userForm = new UserInsert();
        $userForm->render();

        ?>
        
    </div>
