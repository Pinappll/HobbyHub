<div class="auth-container">
        <!-- Section for Login Form -->
        <section class="section form-wrapper form-login active">
            <h2>Connexion</h2>
            <?php 
            // Include the login form configuration and display it
            $loginForm = new \App\Forms\UserLogin();
            $configForm = $loginForm->getConfig();
            $this->includeComponent("form", $configForm, $errorsForm); 
            
            // Display message if available (e.g., login success or error)
            if (isset($this->data["message"])) {
                echo "<h3>" . $this->data["message"] . "</h3>";
            }
            ?>
            <p>Mot de passe oublié ? <a href="#" class="switch-to-forgot-password">Cliquez ici</a></p>
            <p>Pas encore inscrit ? <a href="#" class="switch-to-signup">S'inscrire</a></p>
        </section>

        <!-- Section for Signup Form -->
        <section class="section form-wrapper form-signup">
            <h2>Inscription</h2>
            <?php 
            // Include the registration form configuration and display it
            $registerForm = new \App\Forms\UserInsert();
            $configForm = $registerForm->getConfig();
            $this->includeComponent("form", $configForm, $errorsForm); 
            
            // Display message if available (e.g., registration success or error)
            if (isset($this->data["message"])) {
                echo "<h3>" . $this->data["message"] . "</h3>";
            }
            ?>
            <p>Déjà inscrit ? <a href="#" class="switch-to-login">Se connecter</a></p>
        </section>

        <!-- Section for Forgot Password Form -->
        <section class="section form-wrapper form-forgot-password">
            <h2>Mot de passe oublié</h2>
            <?php 
            // Include the forgot password form configuration and display it
            $forgotPasswordForm = new \App\Forms\UserForgetPassword();
            $configForm = $forgotPasswordForm->getConfig();
            $this->includeComponent("form", $configForm, $errorsForm); 
            
            // Display message if available (e.g., password reset request success or error)
            if (isset($this->data["message"])) {
                echo "<h3>" . $this->data["message"] . "</h3>";
            }
            ?>
            <p>Se souvenir du mot de passe ? <a href="#" class="switch-to-login">Se connecter</a></p>
        </section>
    </div>