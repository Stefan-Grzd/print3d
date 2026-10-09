<?php
// Verbindungsdatei einbinden
require_once 'db.php';

// Beispiel: Daten aus einer Tabelle "user" auslesen
$stmt = $pdo->query("SELECT * FROM kunde");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    echo $user['vorname'] . " " . $user['nachname'] . "<br>";
}
?>