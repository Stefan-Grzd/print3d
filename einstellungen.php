<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$user = $_SESSION['user'];
$form = [
    'vorname' => (string) ($user['vorname'] ?? ''),
    'nachname' => (string) ($user['nachname'] ?? ''),
    'email' => (string) ($user['email'] ?? ''),
    'strasse' => (string) ($user['straße'] ?? $user['strasse'] ?? ''),
    'plz' => (string) ($user['plz'] ?? ''),
    'ort' => (string) ($user['ort'] ?? ''),
];
$error = '';
$notice = $_SESSION['profile_notice'] ?? '';
unset($_SESSION['profile_notice']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $field => $value) {
        $form[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    if (!hash_equals($_SESSION['csrf'], (string) ($_POST['csrf'] ?? ''))) {
        $error = 'Die Anfrage ist abgelaufen. Bitte lade die Seite neu.';
    } elseif (in_array('', $form, true)) {
        $error = 'Bitte fülle alle Felder aus.';
    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Bitte gib eine gültige E-Mail-Adresse ein.';
    } elseif (!ctype_digit($form['plz'])) {
        $error = 'Die PLZ darf nur Zahlen enthalten.';
    } else {
        $emailStmt = $pdo->prepare(
            'SELECT k_id FROM kunde WHERE email = :email AND k_id <> :id LIMIT 1'
        );
        $emailStmt->execute([
            'email' => $form['email'],
            'id' => (int) $user['k_id'],
        ]);

        if ($emailStmt->fetch() !== false) {
            $error = 'Diese E-Mail-Adresse ist bereits vergeben.';
        } else {
            $update = $pdo->prepare(
                'UPDATE kunde
                 SET vorname = :vorname, nachname = :nachname, email = :email,
                     `straße` = :strasse, ort = :ort, plz = :plz
                 WHERE k_id = :id'
            );
            $update->execute([
                'vorname' => $form['vorname'],
                'nachname' => $form['nachname'],
                'email' => $form['email'],
                'strasse' => $form['strasse'],
                'ort' => $form['ort'],
                'plz' => (int) $form['plz'],
                'id' => (int) $user['k_id'],
            ]);

            $self = $pdo->prepare('SELECT * FROM kunde WHERE k_id = :id');
            $self->execute(['id' => (int) $user['k_id']]);
            $updatedUser = $self->fetch();
            if ($updatedUser === false) {
                $error = 'Die Profildaten konnten nicht geladen werden.';
            } else {
                unset($updatedUser['passwort']);
                $_SESSION['user'] = $updatedUser;
                $_SESSION['profile_notice'] = 'Deine Profildaten wurden gespeichert.';
                header('Location: einstellungen.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Einstellungen | Print3d</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="profile-page">
        <section class="profile-intro">
            <div>
                <span class="profile-eyebrow"><i class="bi bi-person-gear" aria-hidden="true"></i> Mein Profil</span>
                <h1>Deine Daten</h1>
                <p>Ändere hier deinen Profilnamen, deine E-Mail-Adresse und deine Lieferadresse.</p>
            </div>
        </section>

        <section class="profile-card admin-form-card" aria-label="Profildaten bearbeiten">
            <?php if ($notice !== ''): ?>
                <div class="admin-message admin-message-ok" role="status"><?= htmlspecialchars($notice, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if ($error !== ''): ?>
                <div class="admin-message admin-message-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form class="admin-form" method="post">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8') ?>">
                <label>
                    Vorname
                    <input class="form-control" type="text" name="vorname" value="<?= htmlspecialchars($form['vorname'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <label>
                    Nachname
                    <input class="form-control" type="text" name="nachname" value="<?= htmlspecialchars($form['nachname'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <label class="admin-form-wide">
                    E-Mail
                    <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($form['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <label class="admin-form-wide">
                    Straße und Hausnummer
                    <input class="form-control" type="text" name="strasse" value="<?= htmlspecialchars($form['strasse'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <label>
                    PLZ
                    <input class="form-control" type="text" name="plz" inputmode="numeric" value="<?= htmlspecialchars($form['plz'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <label>
                    Ort
                    <input class="form-control" type="text" name="ort" value="<?= htmlspecialchars($form['ort'], ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                <div class="admin-form-actions">
                    <button class="profile-primary-action" type="submit"><i class="bi bi-check-lg" aria-hidden="true"></i> Änderungen speichern</button>
                    <a class="profile-outline-action" href="profil.php">Abbrechen</a>
                </div>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>