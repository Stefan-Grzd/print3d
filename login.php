<?php
session_start();
require_once 'db.php';

$loginError = '';
$registerError = '';
$registerSuccess = '';
$email = '';
$registration = [
    'vorname' => '',
    'nachname' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
    'email' => '',
];
$showRegistration = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['form_type'] ?? '') === 'register') {
        $showRegistration = true;
        foreach ($registration as $field => $value) {
            $registration[$field] = trim($_POST[$field] ?? '');
        }
        $registrationPassword = $_POST['register_password'] ?? '';

        if (in_array('', $registration, true) || $registrationPassword === '') {
            $registerError = 'Bitte fülle alle Felder aus.';
        } elseif (!filter_var($registration['email'], FILTER_VALIDATE_EMAIL)) {
            $registerError = 'Bitte gib eine gültige E-Mail-Adresse ein.';
        } elseif (!ctype_digit($registration['plz'])) {
            $registerError = 'Die PLZ darf nur Zahlen enthalten.';
        } else {
            $emailStmt = $pdo->prepare('SELECT k_id FROM kunde WHERE email = :email LIMIT 1');
            $emailStmt->execute(['email' => $registration['email']]);

            if ($emailStmt->fetch() !== false) {
                $registerError = 'Diese E-Mail-Adresse ist bereits registriert.';
            } else {
                $insertStmt = $pdo->prepare(
                    'INSERT INTO kunde (vorname, nachname, email, passwort, straße, ort, plz)
                     VALUES (:vorname, :nachname, :email, :passwort, :strasse, :ort, :plz)'
                );
                $insertStmt->execute([
                    'vorname' => $registration['vorname'],
                    'nachname' => $registration['nachname'],
                    'email' => $registration['email'],
                    'passwort' => password_hash($registrationPassword, PASSWORD_DEFAULT),
                    'strasse' => $registration['strasse'],
                    'ort' => $registration['ort'],
                    'plz' => (int) $registration['plz'],
                ]);
                $registerSuccess = 'Registrierung erfolgreich. Du kannst dich jetzt anmelden.';
                $registration = array_fill_keys(array_keys($registration), '');
            }
        }
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email !== '' && $password !== '') {
            $stmt = $pdo->prepare('SELECT * FROM kunde WHERE email = :email LIMIT 1');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            $passwordIsValid = $user !== false
                && isset($user['passwort'])
                && (
                    password_verify($password, $user['passwort'])
                    || hash_equals((string) $user['passwort'], $password)
                );

            if ($passwordIsValid) {
                if (!password_verify($password, $user['passwort'])) {
                    $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare('UPDATE kunde SET passwort = :passwort WHERE k_id = :id');
                    $updateStmt->execute([
                        'passwort' => $newPasswordHash,
                        'id' => $user['k_id'],
                    ]);
                }

                unset($user['passwort']);
                $_SESSION['user'] = $user;
                header('Location: index.php');
                exit;
            }
        }

        $loginError = 'E-Mail oder Passwort falsch.';
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Print3d</title>
</head>
<body>
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
                    <div class="nav-actions">
                        <a class="nav-action-link" href="#warenkorb" aria-label="Warenkorb" title="Warenkorb">
                            <i class="bi bi-cart3" aria-hidden="true"></i>
                        </a>
                        <a class="nav-link nav-login-link active" aria-current="page" href="login.php">Login</a>
                    </div>
        </div>
    </nav>

        <div class="container<?= $showRegistration ? ' active' : '' ?>" id="container">
        <div class="form-container sign-up">
            <form method="post" action="login.php">
                <input type="hidden" name="form_type" value="register">
                <h1>Konto erstellen</h1>
                <span>Erstelle ein Konto, um auf alle Funktionen von Print3d zuzugreifen.</span>
                <input type="text" name="vorname" placeholder="Name" aria-label="Name" value="<?= htmlspecialchars($registration['vorname'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="text" name="nachname" placeholder="Nachname" aria-label="Nachname" value="<?= htmlspecialchars($registration['nachname'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="text" name="strasse" placeholder="Straße" aria-label="Straße" value="<?= htmlspecialchars($registration['strasse'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="text" name="plz" placeholder="PLZ" aria-label="PLZ" value="<?= htmlspecialchars($registration['plz'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="text" name="ort" placeholder="Ort" aria-label="Ort" value="<?= htmlspecialchars($registration['ort'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="email" name="email" placeholder="E-Mail" aria-label="E-Mail" value="<?= htmlspecialchars($registration['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="password" name="register_password" placeholder="Passwort" aria-label="Passwort" required>
                <button type="submit">Registrieren</button>
                <?php if ($registerError !== ''): ?>
                    <p class="text-danger mt-2 mb-0" role="alert"><?= htmlspecialchars($registerError, ENT_QUOTES, 'UTF-8') ?></p>
                <?php elseif ($registerSuccess !== ''): ?>
                    <p class="text-success mt-2 mb-0" role="status"><?= htmlspecialchars($registerSuccess, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="post" action="login.php">
                <h1>Anmelden</h1>
                <span>Melde dich mit deiner E-Mail-Adresse an, um auf alle Funktionen von Print3d zuzugreifen.</span>
                <input type="email" name="email" placeholder="E-Mail" aria-label="E-Mail" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
                <input type="password" name="password" placeholder="Passwort" aria-label="Passwort" required>
                <a href="#">Passwort vergessen?</a>
                <button type="submit">Anmelden</button>
                <?php if ($loginError !== ''): ?>
                    <p class="text-danger mt-2 mb-0" role="alert"><?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Hallo!</h1>
                    <p>Erstelle dein Konto und entdecke alle Möglichkeiten von Print3d.</p>
                    <button class="hidden" id="login" type="button">Anmelden</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Willkommen zurück!</h1>
                    <p>Melde dich an, um alle Funktionen von Print3d zu nutzen.</p>
                    <button class="hidden" id="register" type="button">Registrieren</button>
                </div>
            </div>
        </div>
    </div>

    
     <footer class="site-footer">
        <div class="site-footer-main">
            <div class="site-footer-brand">
                <a class="site-footer-logo" href="index.php#startseite">Print3d</a>
                <p>Individuelle 3D-Druckteile für Ideen, Projekte und Lösungen, die passen.</p>
                <div class="site-footer-socials" aria-label="Social Media">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="site-footer-column">
                <h2>Plattform</h2>
                <a href="index.php#startseite">Startseite</a>
                <a href="leistungen.php">Leistungen</a>
                <a href="shop.php">Shop</a>
            </div>

            <div class="site-footer-column">
                <h2>Support</h2>
                <a href="kontakt.php">Kontakt</a>
                <a href="mailto:info@print3d.at">info@print3d.at</a>
                <a href="index.php#content5">Anfrage senden</a>
            </div>

            <div class="site-footer-column">
                <h2>Rechtliches</h2>
                <a href="#impressum">Impressum</a>
                <a href="#datenschutz">Datenschutz</a>
            </div>
        </div>

        <div class="site-footer-bottom">
            <span>&copy; 2026 Print3d. Alle Rechte vorbehalten.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"></script>
</body>
</html>