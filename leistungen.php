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
    <nav class="navbar navbar-expand-lg" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" id="logo">
             <img src="img/print3d-logo-lila-magenta-transparent.svg" alt="Print3d" height="40" class="d-inline-block align-text-top">
  
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills justify-content-center w-100">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Startseite</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="leistungen.php">Leistungen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="shop.php">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="kontakt.php">Kontakt</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="chat.php">Chat</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-actions">
                        <a class="nav-action-link" href="warenkorb.php" aria-label="Warenkorb" title="Warenkorb">
                            <i class="bi bi-cart3" aria-hidden="true"></i>
                        </a>
                        <a class="nav-link nav-login-link" href="login.php">Login</a>
                    </div>
        </div>
    </nav>

    <div class="mt-5" id="leistungen-content1">
        <div class="content-copy">
            <h1>Was bieten wir an?</h1>
            <br>
            <p>Ob Ersatzteil, Halterungen oder erste Prototypen: Wir machen aus deiner Vorstellung ein individuelles Bauteil. <br>Oder du findest dein passendes Teil direkt im Shop.</p>
        </div>
        <div class="leistungen-cards">
            <article class="leistung-card">
                <span class="leistung-card-icon" aria-hidden="true">
                    <i class="bi bi-sliders"></i>
                </span>
                <h2>Ersatzteile</h2>
                <p>Ein gebrochener Knopf oder ein fehlender Adapter: bestehende Funktionen neu denken.</p>
            </article>
            <article class="leistung-card">
                <span class="leistung-card-icon" aria-hidden="true">
                    <i class="bi bi-grid-3x3-gap"></i>
                </span>
                <h2>Halterungen</h2>
                <p>Ordnung schaffen und Komponenten dort befestigen, wo sie gebraucht werden.</p>
            </article>
            <article class="leistung-card">
                <span class="leistung-card-icon" aria-hidden="true">
                    <i class="bi bi-box"></i>
                </span>
                <h2>Gehäuse</h2>
                <p>Elektronik umschließen – mit passenden Öffnungen, Deckeln und Befestigungen.</p>
            </article>
            <article class="leistung-card">
                <span class="leistung-card-icon" aria-hidden="true">
                    <i class="bi bi-diagram-3"></i>
                </span>
                <h2>Prototypen</h2>
                <p>Form und Passung greifbar machen, bevor du deinen Entwurf weiterentwickelst.</p>
            </article>
        </div>
    </div>

    <div id="leistungen-content2">
        <div class="row">
            <div class="col-md-6">
                <h2>Das beste Material für die <br> maximale Qualität!</h2>
                <p>Wir verwenden nur die besten Materialien, um sicherzustellen, dass dein Teil die höchste Qualität hat.
                    <br>Doch, welches ist das?
                </p>
               
                <div class="material-layout">
                    <div class="material-nav">
                        <div id="list-example" class="list-group">
                        <button class="list-group-item list-group-item-action" type="button" data-material="PLA" data-info="Ein vielseitiges Material für Prototypen, Modelle und dekorative Bauteile mit sauberer Oberfläche.">PLA</button>
                        <button class="list-group-item list-group-item-action" type="button" data-material="PETG" data-info="Robust und widerstandsfähig – geeignet für funktionale Teile, Halterungen und den täglichen Einsatz.">PETG</button>
                        <button class="list-group-item list-group-item-action" type="button" data-material="ABS / ASA" data-info="Für belastbare Anwendungen mit höherer Temperaturbeständigkeit und guten mechanischen Eigenschaften.">ABS / ASA</button>
                        <button class="list-group-item list-group-item-action" type="button" data-material="TPU" data-info="Flexibel und stoßfest – ideal für Dichtungen, Schutzteile und Bauteile mit elastischen Eigenschaften.">TPU</button>
                        </div>
                        <aside class="material-popover" aria-live="polite" aria-hidden="true">
                            <h4></h4>
                            <p></p>
                        </aside>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section id="leistungen-content3" aria-labelledby="leistungen-content3-title">
        <div class="content-copy">
            <h2 id="leistungen-content3-title">Warum ausgerechnet Print3d?</h2>
            <p>Wir unterstützen dich bei der Umsetzung deiner Idee, egal ob du bereits eine 3D-Datei hast oder nicht.<br>Wir beraten dich gerne und helfen dir bei der Auswahl des richtigen Materials und der passenden Drucktechnologie.</p>
        </div>

        <div id="carouselExampleContent" class="carousel slide leistung-carousel" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
            <div class="carousel-inner">
                <article class="carousel-item active leistung-slide leistung-slide--custom">
                    <div class="leistung-slide-content">
                        <h3>Individuelle Einzelanfertigung</h3>
                        <p>Wir erstellen für dich maßgeschneiderte 3D-Druckteile, die perfekt auf deine Anforderungen zugeschnitten sind.</p>
                    </div>
                </article>
                <article class="carousel-item leistung-slide leistung-slide--materials">
                    <div class="leistung-slide-content">
                        <h3>Verschiedene Materialien</h3>
                        <p>Wir bieten eine Vielzahl an Materialien an, um die perfekte Lösung für deine Anforderungen zu finden.</p>
                    </div>
                </article>
                <article class="carousel-item leistung-slide leistung-slide--price">
                    <div class="leistung-slide-content">
                        <h3>Faire Preise</h3>
                        <p>Wir bieten faire Preise für unsere 3D-Druckdienste, sodass du beste Qualität zu einem günstigen Preis erhältst.</p>
                        <a class="leistung-slide-link" href="kontakt.php">Projekt anfragen <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            </div>
            <div class="leistung-carousel-indicators" aria-label="Carousel-Fortschritt">
                <span class="leistung-carousel-indicator is-active"></span>
                <span class="leistung-carousel-indicator"></span>
                <span class="leistung-carousel-indicator"></span>
            </div>
        </div>
    </section>

    
    <footer class="site-footer">
        <div class="site-footer-main">
            <div class="site-footer-brand">
                <a class="site-footer-logo" href="index.php#startseite">Print3d</a>
                <p>Individuelle 3D-Druckteile für Ideen, Projekte und Lösungen, die passen.</p>
                <div class="site-footer-socials" aria-label="Social Media">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="site-footer-column">
                <h2>Plattform</h2>
                <a href="index.php#startseite">Startseite</a>
                <a href="leistungen.php">Leistungen</a>
                <a href="shop.php">Shop</a>
            </div>

            <div class="site-footer-column">
                <h2>Support</h2>
                <a href="kontakt.php">Kontakt</a>
                <a href="mailto:info@print3d.at">info@print3d.at</a>
                <a href="index.php#content5">Anfrage senden</a>
            </div>

            <div class="site-footer-column">
                <h2>Rechtliches</h2>
                <a href="#impressum">Impressum</a>
                <a href="#datenschutz">Datenschutz</a>
            </div>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
    const leistungCarousel = document.querySelector("#carouselExampleContent");
    const leistungIndicators = document.querySelectorAll(".leistung-carousel-indicator");

    if (leistungCarousel && leistungIndicators.length > 0) {
        leistungCarousel.addEventListener("slid.bs.carousel", (event) => {
            leistungIndicators.forEach((indicator, index) => {
                indicator.classList.toggle("is-active", index === event.to);
            });
        });
    }
</script>
        <div class="site-footer-bottom">
            <span>&copy; 2026 Print3d. Alle Rechte vorbehalten.</span>
        </div>
    </footer>
</body>
</html>