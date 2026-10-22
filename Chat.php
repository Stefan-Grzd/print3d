<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Verbindungsdatei einbinden
require_once 'db.php';

// Beispiel: Daten aus einer Tabelle "user" auslesen
$stmt = $pdo->query("SELECT * FROM kunde");
$users = $stmt->fetchAll();

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
    <title>Chat | Print3d</title>
</head>
<body>
  <?php include 'header.php'; ?>

    <main class="chat-page" aria-label="Nachrichten">
        <aside class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h1>Nachrichten</h1>
                <button class="chat-icon-button" type="button" aria-label="Neue Nachricht"><i class="bi bi-pencil-square" aria-hidden="true"></i></button>
            </div>
            <label class="chat-search" for="chat-search-input">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input id="chat-search-input" type="search" placeholder="Suchen..." autocomplete="off">
            </label>
            <div class="chat-tabs" role="tablist" aria-label="Nachrichtenfilter">
                <button class="chat-tab active" type="button" role="tab" aria-selected="true">Chats</button>
                <button class="chat-tab" type="button" role="tab" aria-selected="false">Anfragen</button>
            </div>
            <div class="chat-list" id="chat-list">
                <button class="chat-contact active" type="button" data-name="Print3d Support" data-chat="support">
                    <span class="chat-avatar">P3</span>
                    <span class="chat-contact-copy"><strong>Print3d Support</strong><span>Wie können wir helfen?</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Max Mustermann" data-chat="max">
                    <span class="chat-avatar">MM</span>
                    <span class="chat-contact-copy"><strong>Max Mustermann</strong><span>Deine Anfrage ist angekommen.</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Julia Weber" data-chat="julia">
                    <span class="chat-avatar">JW</span>
                    <span class="chat-contact-copy"><strong>Julia Weber</strong><span>Aktiv vor 10 Min.</span></span>
                </button>
            </div>
        </aside>

        <section class="chat-main">
            <header class="chat-main-header">
                <div class="chat-main-user">
                    <span class="chat-avatar" id="chat-main-avatar">P3</span>
                    <div><strong id="chat-main-name">Print3d Support</strong><span id="chat-main-status">Online</span></div>
                </div>
                <button class="chat-icon-button" type="button" aria-label="Weitere Optionen"><i class="bi bi-three-dots" aria-hidden="true"></i></button>
            </header>
            <div class="chat-messages" id="chat-messages" aria-live="polite"></div>
            <form class="chat-composer" id="chat-form">
                <button class="chat-icon-button" type="button" aria-label="Datei anhängen"><i class="bi bi-paperclip" aria-hidden="true"></i></button>
                <input id="chat-input" type="text" placeholder="Nachricht schreiben..." autocomplete="off" required>
                <button class="chat-send" type="submit" aria-label="Nachricht senden"><i class="bi bi-send-fill" aria-hidden="true"></i></button>
            </form>
        </section>
    </main>

   <?php include 'footer.php'; ?>
</body>
</html>
