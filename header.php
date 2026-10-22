<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$userName = $_SESSION['user']['vorname'] ?? 'Nutzer';
?>
<nav class="navbar navbar-expand-lg" id="nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" id="logo">
            <img src="img/print3d-logo-lila-magenta-transparent.svg" alt="Print3d" height="40" class="d-inline-block align-text-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-pills justify-content-center w-100">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Startseite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leistungen.php">Leistungen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chat.php">Chat</a>
                </li>
            </ul>
        </div>

        <!-- Hier beginnt der NEUE Teil -->
        <div class="nav-actions">
            <a class="nav-action-link" href="warenkorb.php" aria-label="Warenkorb" title="Warenkorb">
                <i class="bi bi-cart3" aria-hidden="true"></i>
            </a>

            <?php if ($isLoggedIn): ?>
                <div class="dropdown">
                    <a class="nav-action-link" href="#" role="button"
                       id="profileDropdownBtn" data-bs-toggle="dropdown"
                       aria-expanded="false" aria-label="Profilmenü" title="Mein Konto">
                        <i class="bi bi-person-circle" aria-hidden="true"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown"
                        aria-labelledby="profileDropdownBtn">
                        <li class="dropdown-header">
                           Hallo, <?= htmlspecialchars($userName) ?>
                        </li>
                        <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person me-2"></i>Mein Profil</a></li>
                        <li><a class="dropdown-item" href="bestellungen.php"><i class="bi bi-bag me-2"></i>Meine Bestellungen</a></li>
                        <li><a class="dropdown-item" href="einstellungen.php"><i class="bi bi-gear me-2"></i>Einstellungen</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Abmelden</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a class="nav-link nav-login-link active" aria-current="page" href="login.php">Login</a>
            <?php endif; ?>
        </div>
        <!-- Hier endet der NEUE Teil -->
    </div>
</nav>