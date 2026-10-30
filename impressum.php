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
    
    <div class="impressum-header">
         <h1><span class="title">Impressum</span></h1>
        <p>Diplomarbeit im Rahmen der DigBiz Ausbildung an der HAK Mistelbach</p>
</div>
<main class="impressum-page">
    <article class="impressum-content" aria-labelledby="impressum-heading">
        
        <section class="impressum-section">
            <div class="impressum-icon" aria-hidden="true"><i class="bi bi-person-badge-fill"></i></div>
            <div class="impressum-section-content">
                <h2>Erstellt von</h2>
                <ul>
                    <li>Stefan Grozdic</li>
                    <li>Thomas Zuljevic</li>
                    <li>Denis Farcau</li>
                </ul>
            </div>
        </section>

        <section class="impressum-section">
            <div class="impressum-icon" aria-hidden="true"><i class="bi bi-journal-richtext"></i></div>
            <div class="impressum-section-content">
                <h2>Zweck der Webseite</h2>
                <p>Diese Diplomarbeit dient ausschließlich akademischen Zwecken. Zum aktuellen Zeitpunkt besteht keine Gewinnerzielungsabsicht und es wird kein Umsatz erzielt.</p>
            </div>
        </section>

        <section class="impressum-section">
            <div class="impressum-icon" aria-hidden="true"><i class="bi bi-at"></i></div>
            <div class="impressum-section-content">
                <h2>Kontakt</h2>
                <dl>
                    <div>
                        <dt>E-Mail:</dt>
                        <dd><a href="mailto:print3d2027@gmail.com">info@print3d.at</a></dd>
                    </div>
                    <div>
                        <dt>Erstellungsjahr:</dt>
                        <dd>2026/27</dd>
                    </div>
                </dl>
            </div>
        </section>
    </article>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>