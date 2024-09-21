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
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"/></svg>
            </button>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/login" class="header__user-icon">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                </a>
            <?php else: ?>
                <?php
                // Retrieve the user's details
                require_once __DIR__ . '/../../Models/User.php';
                $user = new \App\Models\User();
                $user = $user->getOneBy(['id' => $_SESSION['user_id']], 'object');
                ?>
                <a href="/recipes" class="header__user-icon">Recettes</a>
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
