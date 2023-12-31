<?php
use App\Core\BuildForm;
use App\Forms\UserConnexion;

?>


    <div class="container">
        <section>
        <h2>Connexion</h2>
        </section>
        
        <?php

        $userForm = new UserConnexion();
        $userForm->render();

        ?>
        
    </div>
