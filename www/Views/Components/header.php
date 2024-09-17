<header class="header">
    <div class="header__container">
        <a href="/" class="header__logo">
            <img src="../../dist/assets/images/logo.png" alt="Logo EasyCook">
        </a>
        <div class="header__menu">
            <nav class="header__nav">
                <ul>
                    <?php include "navbar.php"; // Include dynamic navbar ?>
                </ul>
            </nav>

            <button id="dark-mode-toggle" data-icon="moon">
                <?php include "./icons/moon.php"; ?>
            </button>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/login" class="header__user-icon">
                    <?php include "./icons/user.php"; ?>
                </a>
            <?php else: ?>
                <?php
                // Retrieve the user's details
                require_once __DIR__ . '/../../Models/User.php';
                $user = new \App\Models\User();
                $user = $user->getOneBy(['id' => $_SESSION['user_id']], 'object');
                ?>
                
                <?php if ($user && $user->getType_user() === 'admin'): ?>
                    <a href="/admin" class="header__user-icon">Admin</a>
                <?php endif; ?>
                
                <a href="/logout" class="header__user-icon">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            <?php endif; ?>

            <div class="header__burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
