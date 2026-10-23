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
                $_SESSION['show_chat_hint'] = true;  
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
    <?php include 'header.php'; ?>

        <div class="container<?= $showRegistration ? ' active' : '' ?>" id="container">
        <div class="form-container sign-up">
            <form method="post" action="login.php">
                <input type="hidden" name="form_type" value="register">
                <h1>Konto erstellen</h1>
                <span>Erstelle ein Konto, um auf alle Funktionen von Print3d zuzugreifen.</span>
                <input class="field-name" type="text" name="vorname" placeholder="Name" aria-label="Name" value="<?= htmlspecialchars($registration['vorname'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-last-name" type="text" name="nachname" placeholder="Nachname" aria-label="Nachname" value="<?= htmlspecialchars($registration['nachname'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-street" type="text" name="strasse" placeholder="Straße" aria-label="Straße" value="<?= htmlspecialchars($registration['strasse'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-postcode" type="text" name="plz" placeholder="PLZ" aria-label="PLZ" value="<?= htmlspecialchars($registration['plz'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-city" type="text" name="ort" placeholder="Ort" aria-label="Ort" value="<?= htmlspecialchars($registration['ort'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-email" type="email" name="email" placeholder="E-Mail" aria-label="E-Mail" value="<?= htmlspecialchars($registration['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                <input class="field-password" type="password" name="register_password" placeholder="Passwort" aria-label="Passwort" required>
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

    
     <?php include 'footer.php'; ?>
</body>
</html>