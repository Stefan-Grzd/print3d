<?php
$host = 'localhost';
$dbname = 'print3d';
$username = 'root';
$password = '';

try {
    // DSN (Data Source Name) erstellen
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    // PDO-Instanz erstellen
    $pdo = new PDO($dsn, $username, $password);
    
    // Fehler-Modus auf Exception stellen
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Optional: Erfolgskontrolle für den Test
    // echo "Verbindung erfolgreich!";
} catch (PDOException $e) {
    // Bei Fehler Abbruch mit Fehlermeldung
    die("Verbindungsfehler: " . $e->getMessage());
}

?>