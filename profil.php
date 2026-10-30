<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
$fullName = trim(($user['vorname'] ?? '') . ' ' . ($user['nachname'] ?? ''));
$firstName = $user['vorname'] ?? 'Nutzer';
$initials = strtoupper(substr((string) ($user['vorname'] ?? 'N'), 0, 1) . substr((string) ($user['nachname'] ?? ''), 0, 1));
$street = $user['straße'] ?? $user['strasse'] ?? '';
$address = trim($street . ', ' . ($user['plz'] ?? '') . ' ' . ($user['ort'] ?? ''), " ,");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Mein Profil | Print3d</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="profile-page">
        <section class="profile-intro">
            <div>
                <h1>Schön dich zu sehen, <span><?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8') ?>.</span></h1>
                <p>Verwalte deine Daten & behalte deine Bestellungen im Blick.</p>
            </div>
         
        </section>

        <section class="profile-dashboard" aria-label="Profilübersicht">
            <article class="profile-card profile-card-main">
                <div class="profile-card-top">
                    <span class="profile-card-label">Mein Profil</span>
                    <span class="profile-status"><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Aktiv</span>
                </div>
                <div class="profile-identity">
                    <div class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($initials, ENT_QUOTES, 'UTF-8') ?></div>
                    <div>
                        <h2><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></h2>
                        <p><?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
                <div class="profile-card-actions">
                    <a href="einstellungen.php"><i class="bi bi-pencil" aria-hidden="true"></i> Daten bearbeiten</a>
                    <a href="bestellungen.php"><i class="bi bi-bag" aria-hidden="true"></i> Bestellungen ansehen</a>
                </div>
            </article>

            <article class="profile-card profile-card-order">
              
                <span class="profile-card-label">Deine Bestellungen</span>
                <h2>Alles im Blick</h2>
                <p>Finde deine bisherigen Bestellungen und den aktuellen Status jederzeit schnell wieder.</p>
                <a class="profile-text-link" href="bestellungen.php">Zu meinen Bestellungen <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
            </article>

            <article class="profile-card profile-card-address">
                <div class="profile-card-top">
                    <span class="profile-card-label">Lieferadresse</span>
                    <i class="bi bi-geo-alt profile-card-top-icon" aria-hidden="true"></i>
                </div>
                <div class="profile-address">
                    <strong><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <a class="profile-text-link" href="einstellungen.php">Adresse verwalten <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
            </article>

            <article class="profile-card profile-card-help">
                <div class="profile-help-content">
                    <h2>Wir sind für dich da.</h2>
                    <p>Du hast Fragen zu deinem Projekt oder deiner Bestellung?</p>
                    <a class="profile-outline-action" href="kontakt.php">Kontakt aufnehmen <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>
                <i class="bi bi-chat-heart profile-help-art" aria-hidden="true"></i>
            </article>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>