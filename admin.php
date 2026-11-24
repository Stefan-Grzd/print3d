<?php
session_start();
require_once 'db.php';
require_once 'admin_lib.php';

$admin = requireAdmin();
ensureProductColumns($pdo);

$categories = [
    'haushalt' => 'Haushalt',
    'werkstatt' => 'Werkstatt',
    'organisation' => 'Organisation',
];

$bereich = $_GET['bereich'] ?? 'kunden';
if (!in_array($bereich, ['kunden', 'produkte'], true)) {
    $bereich = 'kunden';
}

$notice = $_SESSION['admin_notice'] ?? '';
unset($_SESSION['admin_notice']);
$error = '';
$form = null;
$editingId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$creating = isset($_GET['neu']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bereich = $_POST['bereich'] ?? $bereich;
    if (!in_array($bereich, ['kunden', 'produkte'], true)) {
        $bereich = 'kunden';
    }

    if (!hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''))) {
        $error = 'Die Anfrage ist abgelaufen. Bitte lade die Seite neu.';
    } else {
        $action = $_POST['action'] ?? '';
        try {
            if ($action === 'save_kunde') {
                $id = (int) ($_POST['k_id'] ?? 0);
                $form = [
                    'k_id' => $id,
                    'vorname' => trim($_POST['vorname'] ?? ''),
                    'nachname' => trim($_POST['nachname'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'straße' => trim($_POST['strasse'] ?? ''),
                    'plz' => trim($_POST['plz'] ?? ''),
                    'ort' => trim($_POST['ort'] ?? ''),
                ];

                if ($form['vorname'] === '' || $form['nachname'] === '' || $form['email'] === '' || $form['straße'] === '' || $form['plz'] === '' || $form['ort'] === '') {
                    $error = 'Bitte fülle alle Kundenfelder aus.';
                } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                    $error = 'Bitte gib eine gültige E-Mail-Adresse ein.';
                } elseif (!ctype_digit($form['plz'])) {
                    $error = 'Die PLZ darf nur Zahlen enthalten.';
                } else {
                    $emailStmt = $pdo->prepare('SELECT k_id FROM kunde WHERE email = :email AND k_id <> :id LIMIT 1');
                    $emailStmt->execute(['email' => $form['email'], 'id' => $id]);
                    if ($emailStmt->fetch() !== false) {
                        $error = 'Diese E-Mail-Adresse ist bereits vergeben.';
                    } else {
                        $update = $pdo->prepare(
                            'UPDATE kunde
                             SET vorname = :vorname, nachname = :nachname, email = :email, `straße` = :strasse, ort = :ort, plz = :plz
                             WHERE k_id = :id'
                        );
                        $update->execute([
                            'vorname' => $form['vorname'],
                            'nachname' => $form['nachname'],
                            'email' => $form['email'],
                            'strasse' => $form['straße'],
                            'ort' => $form['ort'],
                            'plz' => (int) $form['plz'],
                            'id' => $id,
                        ]);

                        if ($id === (int) ($admin['k_id'] ?? 0)) {
                            $self = $pdo->prepare('SELECT * FROM kunde WHERE k_id = :id');
                            $self->execute(['id' => $id]);
                            $updatedUser = $self->fetch();
                            if ($updatedUser !== false) {
                                unset($updatedUser['passwort']);
                                $_SESSION['user'] = $updatedUser;
                            }
                        }

                        $_SESSION['admin_notice'] = 'Kunde wurde gespeichert.';
                        header('Location: admin.php?bereich=kunden');
                        exit;
                    }
                }
                $editingId = $id;
            } elseif ($action === 'delete_kunde') {
                $id = (int) ($_POST['k_id'] ?? 0);
                if ($id === (int) ($admin['k_id'] ?? 0)) {
                    $error = 'Das eigene Admin-Konto kann nicht gelöscht werden.';
                } elseif ($id > 0) {
                    $delete = $pdo->prepare('DELETE FROM kunde WHERE k_id = :id');
                    $delete->execute(['id' => $id]);
                    $_SESSION['admin_notice'] = 'Kunde wurde gelöscht.';
                    header('Location: admin.php?bereich=kunden');
                    exit;
                }
            } elseif ($action === 'save_produkt') {
                $id = (int) ($_POST['produkt_id'] ?? 0);
                $form = [
                    'produkt_id' => $id,
                    'name' => trim($_POST['name'] ?? ''),
                    'preis' => str_replace(',', '.', trim($_POST['preis'] ?? '')),
                    'material' => trim($_POST['material'] ?? ''),
                    'kategorie' => $_POST['kategorie'] ?? '',
                    'beschreibung' => trim($_POST['beschreibung'] ?? ''),
                    'bild' => trim($_POST['bild'] ?? ''),
                    'badge' => trim($_POST['badge'] ?? ''),
                ];

                if ($form['name'] === '' || $form['preis'] === '' || $form['material'] === '' || $form['beschreibung'] === '') {
                    $error = 'Bitte fülle Name, Preis, Material und Beschreibung aus.';
                } elseif (!is_numeric($form['preis']) || (float) $form['preis'] < 0) {
                    $error = 'Bitte gib einen gültigen Preis ein.';
                } elseif (!isset($categories[$form['kategorie']])) {
                    $error = 'Bitte wähle eine Kategorie.';
                } elseif ($form['bild'] !== '' && !preg_match('#^(img/|https?://)[^\s<>"\']+$#', $form['bild'])) {
                    $error = 'Der Bildpfad muss mit img/ oder http beginnen.';
                } else {
                    $params = [
                        'name' => $form['name'],
                        'preis' => number_format((float) $form['preis'], 2, '.', ''),
                        'material' => $form['material'],
                        'kategorie' => $form['kategorie'],
                        'beschreibung' => $form['beschreibung'],
                        'bild' => $form['bild'] !== '' ? $form['bild'] : 'img/bspbild1.jpeg',
                        'badge' => $form['badge'] !== '' ? $form['badge'] : null,
                    ];

                    if ($id > 0) {
                        $params['id'] = $id;
                        $save = $pdo->prepare(
                            'UPDATE produkt
                             SET name = :name, preis = :preis, material = :material, kategorie = :kategorie,
                                 beschreibung = :beschreibung, bild = :bild, badge = :badge
                             WHERE produkt_id = :id'
                        );
                        $save->execute($params);
                        $_SESSION['admin_notice'] = 'Produkt wurde gespeichert.';
                    } else {
                        $save = $pdo->prepare(
                            'INSERT INTO produkt (name, preis, material, kategorie, beschreibung, bild, badge)
                             VALUES (:name, :preis, :material, :kategorie, :beschreibung, :bild, :badge)'
                        );
                        $save->execute($params);
                        $_SESSION['admin_notice'] = 'Produkt wurde angelegt.';
                    }

                    header('Location: admin.php?bereich=produkte');
                    exit;
                }
                $editingId = $id;
                $creating = $id === 0;
            } elseif ($action === 'delete_produkt') {
                $id = (int) ($_POST['produkt_id'] ?? 0);
                if ($id > 0) {
                    $delete = $pdo->prepare('DELETE FROM produkt WHERE produkt_id = :id');
                    $delete->execute(['id' => $id]);
                    $_SESSION['admin_notice'] = 'Produkt wurde gelöscht.';
                    header('Location: admin.php?bereich=produkte');
                    exit;
                }
            }
        } catch (PDOException $exception) {
            if ((string) $exception->getCode() === '23000') {
                $error = 'Der Eintrag wird noch verwendet und kann nicht gelöscht werden.';
            } else {
                $error = 'Die Änderung konnte nicht gespeichert werden.';
            }
        }
    }
}

$customers = $pdo->query('SELECT k_id, vorname, nachname, email, `straße`, ort, plz FROM kunde ORDER BY k_id')->fetchAll();
$products = $pdo->query('SELECT * FROM produkt ORDER BY produkt_id')->fetchAll();

if ($form === null && $bereich === 'kunden' && $editingId > 0) {
    foreach ($customers as $customer) {
        if ((int) $customer['k_id'] === $editingId) {
            $form = $customer;
            break;
        }
    }
}

if ($form === null && $bereich === 'produkte' && ($editingId > 0 || $creating)) {
    $form = [
        'produkt_id' => 0,
        'name' => '',
        'preis' => '',
        'material' => 'PLA',
        'kategorie' => 'haushalt',
        'beschreibung' => '',
        'bild' => 'img/bspbild1.jpeg',
        'badge' => '',
    ];
    foreach ($products as $product) {
        if ((int) $product['produkt_id'] === $editingId) {
            $form = $product;
            break;
        }
    }
}

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
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
    <title>Admin-Panel | Print3d</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="profile-page admin-panel">
        <section class="profile-intro">
            <div>
                <span class="profile-eyebrow"><i class="bi bi-shield-lock" aria-hidden="true"></i> Nur für Admin</span>
                <h1>Admin-<span>Panel</span></h1>
                <p>Hier siehst du alle Kunden und Produkte und kannst sie bearbeiten oder löschen.</p>
            </div>
        </section>

        <nav class="admin-tabs" aria-label="Admin-Bereiche">
            <a class="<?= $bereich === 'kunden' ? 'is-active' : '' ?>" href="admin.php?bereich=kunden">Kunden</a>
            <a class="<?= $bereich === 'produkte' ? 'is-active' : '' ?>" href="admin.php?bereich=produkte">Produkte</a>
        </nav>

        <?php if ($notice !== ''): ?>
            <p class="admin-message admin-message-ok" role="status"><?= h($notice) ?></p>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <p class="admin-message admin-message-error" role="alert"><?= h($error) ?></p>
        <?php endif; ?>

        <?php if ($bereich === 'kunden'): ?>
            <?php if (is_array($form) && isset($form['k_id'])): ?>
                <section class="profile-card admin-form-card">
                    <span class="profile-card-label">Kunde bearbeiten</span>
                    <form method="post" action="admin.php?bereich=kunden&edit=<?= (int) $form['k_id'] ?>" class="admin-form">
                        <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                        <input type="hidden" name="action" value="save_kunde">
                        <input type="hidden" name="bereich" value="kunden">
                        <input type="hidden" name="k_id" value="<?= (int) $form['k_id'] ?>">
                        <label>Vorname<input class="form-control" type="text" name="vorname" value="<?= h($form['vorname'] ?? '') ?>" required></label>
                        <label>Nachname<input class="form-control" type="text" name="nachname" value="<?= h($form['nachname'] ?? '') ?>" required></label>
                        <label>E-Mail<input class="form-control" type="email" name="email" value="<?= h($form['email'] ?? '') ?>" required></label>
                        <label>Straße<input class="form-control" type="text" name="strasse" value="<?= h($form['straße'] ?? '') ?>" required></label>
                        <label>PLZ<input class="form-control" type="text" name="plz" value="<?= h((string) ($form['plz'] ?? '')) ?>" required></label>
                        <label>Ort<input class="form-control" type="text" name="ort" value="<?= h($form['ort'] ?? '') ?>" required></label>
                        <div class="admin-form-actions">
                            <button class="profile-primary-action" type="submit">Speichern</button>
                            <a class="profile-outline-action" href="admin.php?bereich=kunden">Abbrechen</a>
                        </div>
                    </form>
                </section>
            <?php endif; ?>

            <section class="profile-card admin-table-card">
                <div class="profile-card-top">
                    <span class="profile-card-label">Alle Kunden</span>
                    <span><?= count($customers) ?> Einträge</span>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Adresse</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                                <?php $address = trim(($customer['straße'] ?? '') . ', ' . ($customer['plz'] ?? '') . ' ' . ($customer['ort'] ?? ''), ' ,'); ?>
                                <tr>
                                    <td><?= h(trim($customer['vorname'] . ' ' . $customer['nachname'])) ?></td>
                                    <td><?= h($customer['email']) ?></td>
                                    <td><?= h($address) ?></td>
                                    <td class="admin-actions">
                                        <a href="admin.php?bereich=kunden&edit=<?= (int) $customer['k_id'] ?>">Bearbeiten</a>
                                        <?php if ((int) $customer['k_id'] !== (int) ($admin['k_id'] ?? 0)): ?>
                                            <form method="post" action="admin.php?bereich=kunden" onsubmit="return confirm('Diesen Kunden wirklich löschen?');">
                                                <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                                                <input type="hidden" name="action" value="delete_kunde">
                                                <input type="hidden" name="bereich" value="kunden">
                                                <input type="hidden" name="k_id" value="<?= (int) $customer['k_id'] ?>">
                                                <button type="submit">Löschen</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php else: ?>
            <div class="admin-toolbar">
                <a class="profile-primary-action" href="admin.php?bereich=produkte&neu=1">Neues Produkt</a>
            </div>

            <?php if (is_array($form)): ?>
                <section class="profile-card admin-form-card">
                    <span class="profile-card-label"><?= (int) ($form['produkt_id'] ?? 0) > 0 ? 'Produkt bearbeiten' : 'Neues Produkt' ?></span>
                    <form method="post" action="admin.php?bereich=produkte<?= (int) ($form['produkt_id'] ?? 0) > 0 ? '&edit=' . (int) $form['produkt_id'] : '&neu=1' ?>" class="admin-form">
                        <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                        <input type="hidden" name="action" value="save_produkt">
                        <input type="hidden" name="bereich" value="produkte">
                        <input type="hidden" name="produkt_id" value="<?= (int) ($form['produkt_id'] ?? 0) ?>">
                        <label>Name<input class="form-control" type="text" name="name" value="<?= h($form['name'] ?? '') ?>" required></label>
                        <label>Preis in €<input class="form-control" type="text" name="preis" inputmode="decimal" value="<?= h((string) ($form['preis'] ?? '')) ?>" required></label>
                        <label>Material<input class="form-control" type="text" name="material" value="<?= h($form['material'] ?? '') ?>" required></label>
                        <label>Kategorie
                            <select class="form-select" name="kategorie" required>
                                <?php foreach ($categories as $value => $label): ?>
                                    <option value="<?= h($value) ?>" <?= ($form['kategorie'] ?? '') === $value ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label class="admin-form-wide">Beschreibung<textarea class="form-control" name="beschreibung" rows="3" required><?= h($form['beschreibung'] ?? '') ?></textarea></label>
                        <label>Bildpfad<input class="form-control" type="text" name="bild" value="<?= h($form['bild'] ?? '') ?>" placeholder="img/bspbild1.jpeg"></label>
                        <label>Badge<input class="form-control" type="text" name="badge" value="<?= h($form['badge'] ?? '') ?>" placeholder="Neu oder Bestseller"></label>
                        <div class="admin-form-actions">
                            <button class="profile-primary-action" type="submit">Speichern</button>
                            <a class="profile-outline-action" href="admin.php?bereich=produkte">Abbrechen</a>
                        </div>
                    </form>
                </section>
            <?php endif; ?>

            <section class="profile-card admin-table-card">
                <div class="profile-card-top">
                    <span class="profile-card-label">Alle Produkte</span>
                    <span><?= count($products) ?> Einträge</span>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Preis</th>
                                <th>Kategorie</th>
                                <th>Material</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products === []): ?>
                                <tr><td colspan="5">Noch keine Produkte vorhanden.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= h($product['name']) ?></td>
                                    <td><?= h(number_format((float) $product['preis'], 2, ',', '.')) ?> €</td>
                                    <td><?= h($categories[$product['kategorie']] ?? (string) $product['kategorie']) ?></td>
                                    <td><?= h($product['material']) ?></td>
                                    <td class="admin-actions">
                                        <a href="admin.php?bereich=produkte&edit=<?= (int) $product['produkt_id'] ?>">Bearbeiten</a>
                                        <form method="post" action="admin.php?bereich=produkte" onsubmit="return confirm('Dieses Produkt wirklich löschen?');">
                                            <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                                            <input type="hidden" name="action" value="delete_produkt">
                                            <input type="hidden" name="bereich" value="produkte">
                                            <input type="hidden" name="produkt_id" value="<?= (int) $product['produkt_id'] ?>">
                                            <button type="submit">Löschen</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
