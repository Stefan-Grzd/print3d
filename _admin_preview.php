<?php
session_start();
$as = $_GET['as'] ?? 'admin';
if ($as === 'user') {
    $_SESSION['user'] = [
        'k_id' => 1,
        'vorname' => 'Jon',
        'nachname' => 'Doe',
        'email' => 'Doe@gmail.com',
    ];
} else {
    $_SESSION['user'] = [
        'k_id' => 4,
        'vorname' => 'Admin',
        'nachname' => 'Admin',
        'email' => 'admin@gmail.com',
    ];
}
$target = $_GET['to'] ?? 'admin.php';
if (!preg_match('/^[a-z0-9.]+$/i', $target)) {
    $target = 'admin.php';
}
header('Location: ' . $target);
exit;
