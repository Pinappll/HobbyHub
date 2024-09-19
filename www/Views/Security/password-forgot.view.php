<div class="auth-container">

<!-- Section for Forgot Password Form -->
<section class="section form-wrapper form-forgot-password">
          
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