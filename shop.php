<?php
session_start();
require_once 'db.php';
require_once 'admin_lib.php';
ensureProductColumns($pdo);
$shopProducts = $pdo->query('SELECT * FROM produkt ORDER BY produkt_id')->fetchAll();
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

    <main class="shop-page">
        <section class="shop-hero">
            <div>
                <h1>Praktische Teile für<br><span>deine Ideen.</span></h1>
                <p>Entdecke ausgewählte 3D-Druckteile für Haushalt, Werkstatt und deine nächsten Projekte.</p>
                <a class="shop-hero-button" href="#produkte">Produkte entdecken <i class="bi bi-arrow-down"></i></a>
            </div>
            <div class="shop-hero-art" aria-hidden="true">
                <img src="img/print3d-logo-lila-magenta-transparent.svg" alt="Print3d Logo">
            </div>
        </section>

        <section class="shop-benefits" aria-label="Vorteile">
            <div><i class="bi bi-box-seam"></i><span><strong>Versandbereit</strong>sorgfältig verpackt</span></div>
            <div><i class="bi bi-palette"></i><span><strong>Ausgewählte Materialien</strong>passend zum Einsatz</span></div>
            <div><i class="bi bi-chat-dots"></i><span><strong>Persönliche Beratung</strong>bei Fragen zum Produkt</span></div>
        </section>

        <section class="shop-catalog" id="produkte">
            <div class="shop-section-heading">
                <div>
                    <span class="shop-eyebrow">Unsere Auswahl</span>
                    <h2>Finde dein passendes Teil:</h2>
                </div>
                <div class="shop-tools">
                    <label class="shop-search">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <input type="search" id="productSearch" placeholder="Produkte suchen..." aria-label="Produkte suchen">
                    </label>
                    <select id="productFilter" aria-label="Produkte filtern">
                        <option value="all">Alle Kategorien</option>
                        <option value="haushalt">Haushalt</option>
                        <option value="werkstatt">Werkstatt</option>
                        <option value="organisation">Organisation</option>
                    </select>
                </div>
            </div>

            <div class="product-grid" id="productGrid">
                <?php foreach ($shopProducts as $product): ?>
                    <?php
                    $category = (string) ($product['kategorie'] ?? '');
                    $categoryLabel = productCategoryLabel($category);
                    $price = (float) $product['preis'];
                    $image = $product['bild'] !== '' ? $product['bild'] : 'img/bspbild1.jpeg';
                    $badge = trim((string) ($product['badge'] ?? ''));
                    $badgeClass = strcasecmp($badge, 'Neu') === 0 ? 'product-badge product-badge-new' : 'product-badge';
                    ?>
                    <article class="product-card" data-category="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>" data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                        <div class="product-image">
                            <?php if ($badge !== ''): ?>
                                <span class="<?= $badgeClass ?>"><?= htmlspecialchars($badge, ENT_QUOTES, 'UTF-8') ?></span>
                            <?php endif; ?>
                            <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="product-card-body">
                            <span class="product-category"><?= htmlspecialchars($categoryLabel, ENT_QUOTES, 'UTF-8') ?></span>
                            <h3><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p><?= htmlspecialchars((string) $product['beschreibung'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="product-buy">
                                <strong><?= htmlspecialchars(number_format($price, 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</strong>
                                <button type="button" class="add-to-cart" data-product="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" data-price="<?= htmlspecialchars(number_format($price, 2, '.', ''), ENT_QUOTES, 'UTF-8') ?>">In den Warenkorb</button>
                                <span class="product-login-popover" role="status">Melde dich an, um zu bestellen. <a href="login.php">Zum Login</a></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <p class="shop-empty" id="shopEmpty" <?= $shopProducts === [] ? '' : 'hidden' ?>>Keine Produkte gefunden. Probiere einen anderen Suchbegriff.</p>
        </section>
    </main>
        
    <?php include 'footer.php'; ?>
</body>
</html>