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
            <a class="navbar-brand" href="#startseite" id="logo">
             <img src="img/print3d-logo-lila-magenta-transparent.svg" alt="Print3d" height="40" class="d-inline-block align-text-top">
  
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills justify-content-center w-100">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php#startseite">Startseite</a>
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
                        <a class="nav-action-link" href="#warenkorb" aria-label="Warenkorb" title="Warenkorb">
                            <i class="bi bi-cart3" aria-hidden="true"></i>
                        </a>
                        <a class="nav-action-link" href="#account" aria-label="Mein Account" title="Mein Account">
                            <i class="bi bi-person-circle" aria-hidden="true"></i>
                        </a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        const materialItems = document.querySelectorAll("#leistungen-content2 .list-group-item");
        const materialPopover = document.querySelector("#leistungen-content2 .material-popover");
        const materialTitle = materialPopover.querySelector("h4");
        const materialInfo = materialPopover.querySelector("p");

        function hideMaterial() {
            materialPopover.setAttribute("aria-hidden", "true");
            materialPopover.classList.remove("is-visible");
        }

        function showMaterial(item) {
            materialTitle.textContent = item.dataset.material;
            materialInfo.textContent = item.dataset.info;
            if (window.matchMedia("(max-width: 767.98px)").matches) {
                materialPopover.style.top = "";
            } else {
                materialPopover.style.top = `${item.offsetTop}px`;
            }
            materialPopover.setAttribute("aria-hidden", "false");
            materialPopover.classList.add("is-visible");
        }

        materialItems.forEach((item) => {
            item.addEventListener("mouseenter", () => showMaterial(item));
            item.addEventListener("mouseleave", hideMaterial);
            item.addEventListener("focus", () => showMaterial(item));
            item.addEventListener("click", () => {
                materialItems.forEach((entry) => entry.classList.remove("active"));
                item.classList.add("active");
                showMaterial(item);
            });
        });
    </script>
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

        <div class="site-footer-bottom">
            <span>&copy; 2026 Print3d. Alle Rechte vorbehalten.</span>
        </div>
    </footer>
  </body>
</body>
</html>