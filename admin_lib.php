<?php

function isAdminUser(?array $user): bool
{
    if ($user === null) {
        return false;
    }

    return strcasecmp(trim((string) ($user['vorname'] ?? '')), 'Admin') === 0;
}

function requireAdmin(): array
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isAdminUser($_SESSION['user'] ?? null)) {
        header('Location: index.php');
        exit;
    }

    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['user'];
}

function ensureProductColumns(PDO $pdo): void
{
    $columns = [];
    foreach ($pdo->query('SHOW COLUMNS FROM produkt') as $column) {
        $columns[$column['Field']] = strtolower((string) $column['Type']);
    }

    if (!isset($columns['kategorie'])) {
        $pdo->exec('ALTER TABLE produkt ADD COLUMN kategorie VARCHAR(100) NULL');
    }
    if (!isset($columns['beschreibung'])) {
        $pdo->exec('ALTER TABLE produkt ADD COLUMN beschreibung TEXT NULL');
    }
    if (!isset($columns['bild'])) {
        $pdo->exec('ALTER TABLE produkt ADD COLUMN bild VARCHAR(255) NULL');
    }
    if (!isset($columns['badge'])) {
        $pdo->exec('ALTER TABLE produkt ADD COLUMN badge VARCHAR(50) NULL');
    }
    if (isset($columns['preis']) && str_contains($columns['preis'], 'decimal(65,0)')) {
        $pdo->exec('ALTER TABLE produkt MODIFY preis DECIMAL(10,2) NOT NULL DEFAULT 0');
    }
}

function productCategoryLabel(string $category): string
{
    return match ($category) {
        'haushalt' => 'Haushalt',
        'werkstatt' => 'Werkstatt',
        'organisation' => 'Organisation',
        default => $category,
    };
}
