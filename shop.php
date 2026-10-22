<?php session_start(); ?>
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
                <article class="product-card" data-category="haushalt" data-name="Kabelhalter Set">
                    <div class="product-image"><span class="product-badge">Bestseller</span><img src="img/bspbild1.jpeg" alt="Kabelhalter Set"></div>
                    <div class="product-card-body"><span class="product-category">Haushalt</span><h3>Kabelhalter Set</h3><p>Ordnung auf dem Schreibtisch mit drei praktischen Kabelclips.</p><div class="product-buy"><strong>8,90 €</strong><button type="button" class="add-to-cart" data-product="Kabelhalter Set" data-price="8.90">In den Warenkorb</button></div></div>
                </article>
                <article class="product-card" data-category="werkstatt" data-name="Universal-Halterung">
                    <div class="product-image"><img src="img/bspbild2.jpeg" alt="Universal-Halterung"></div>
                    <div class="product-card-body"><span class="product-category">Werkstatt</span><h3>Universal-Halterung</h3><p>Flexible Halterung für Werkzeuge, Controller und kleine Geräte.</p><div class="product-buy"><strong>14,90 €</strong><button type="button" class="add-to-cart" data-product="Universal-Halterung" data-price="14.90">In den Warenkorb</button></div></div>
                </article>
                <article class="product-card" data-category="organisation" data-name="Modulares Ablagefach">
                    <div class="product-image"><span class="product-badge product-badge-new">Neu</span><img src="img/bspbild3.jpg" alt="Modulares Ablagefach"></div>
                    <div class="product-card-body"><span class="product-category">Organisation</span><h3>Modulares Ablagefach</h3><p>Erweiterbares Fach für Kleinteile, Bürobedarf und Zubehör.</p><div class="product-buy"><strong>12,50 €</strong><button type="button" class="add-to-cart" data-product="Modulares Ablagefach" data-price="12.50">In den Warenkorb</button></div></div>
                </article>
                <article class="product-card" data-category="werkstatt" data-name="Werkzeug-Organizer">
                    <div class="product-image"><img src="img/bspbild1.jpeg" alt="Werkzeug-Organizer"></div>
                    <div class="product-card-body"><span class="product-category">Werkstatt</span><h3>Werkzeug-Organizer</h3><p>Hält Bits, Schrauben und kleine Werkzeuge übersichtlich an ihrem Platz.</p><div class="product-buy"><strong>18,90 €</strong><button type="button" class="add-to-cart" data-product="Werkzeug-Organizer" data-price="18.90">In den Warenkorb</button></div></div>
                </article>
                <article class="product-card" data-category="haushalt" data-name="Kopfhörerhalter">
                    <div class="product-image"><img src="img/bspbild2.jpeg" alt="Kopfhörerhalter"></div>
                    <div class="product-card-body"><span class="product-category">Haushalt</span><h3>Kopfhörerhalter</h3><p>Platzsparende Ablage für Kopfhörer am Tisch oder unter dem Regal.</p><div class="product-buy"><strong>10,90 €</strong><button type="button" class="add-to-cart" data-product="Kopfhörerhalter" data-price="10.90">In den Warenkorb</button></div></div>
                </article>
                <article class="product-card" data-category="organisation" data-name="Pflanzenclips">
                    <div class="product-image"><img src="img/bspbild3.jpg" alt="Pflanzenclips"></div>
                    <div class="product-card-body"><span class="product-category">Organisation</span><h3>Pflanzenclips</h3><p>Unauffällige Clips für Rankhilfen, Kabel und kleine Pflanzenstützen.</p><div class="product-buy"><strong>6,90 €</strong><button type="button" class="add-to-cart" data-product="Pflanzenclips" data-price="6.90">In den Warenkorb</button></div></div>
                </article>
            </div>
            <p class="shop-empty" id="shopEmpty" hidden>Keine Produkte gefunden. Probiere einen anderen Suchbegriff.</p>
        </section>

        <aside class="shop-cart" id="warenkorb" aria-live="polite">
            <div><i class="bi bi-cart3"></i><span><strong>Dein Warenkorb</strong><small id="cartMessage">Noch keine Produkte ausgewählt</small></span></div>
            <strong id="cartTotal">0,00 €</strong>
        </aside>
    </main>
        
    <?php include 'footer.php'; ?>
</body>
</html>