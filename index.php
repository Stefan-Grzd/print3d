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

    <div class="mt-5" id="content1">
        <div class="content-copy">
            <h1>Ein Teil fehlt? Deine Lösung <br> beginnt <span class="hier">hier.</span></h1>
            <p>Ob Ersatzteil, Halterung oder erster Prototyp: Wir machen aus deiner <br>
             3D-Datei ein individuelles Bauteil. Oder du findest dein passendes Teil direkt im Shop.</p>
        </div>
         <dotlottie-player
             src="3Ddruck.lottie"
             autoplay
             loop
             aria-label="Animierte 3D-Darstellung"
             class="img-fluid mt-4"
             id="bspbild2">
         </dotlottie-player>
    </div>

    <div id="content2">
        <div class="row">
            <div class="col-md-6">
                <h2>Ein Interesse. Tausende Lösungen.</h2>
                <p>Hast du Interesse an 3D gedruckte Teile kannst dich aber nicht entscheiden? Schau in unserem Shop nach und finde das passende Teil für deine Anwendung.</p>
                <a href="shop.php" class="btn btn-outline-primary" id="druckauftrag-btn">Zum Shop</a>
            </div>
        </div>

    </div>

    <div id="content3">
        <div class="content3-heading">
            <div>
                <h2>Vier Schritte. Ein klarer Ablauf!</h2>
            </div>
           
        </div>

        <div class="process-cards">
            <article class="process-card">
                <span class="process-number">01</span>
                <h3>Datei &amp; Idee senden</h3>
                <p>3D-Modell, Stückzahl und Einsatzzweck angeben. Maße und besondere Anforderungen ergänzen.</p>
            </article>
            <article class="process-card">
                <span class="process-number">02</span>
                <h3>Machbarkeit klären</h3>
                <p>Geometrie, Material und Druckausrichtung werden geprüft. Offene Fragen klären wir mit dir.</p>
            </article>
            <article class="process-card">
                <span class="process-number">03</span>
                <h3>Angebot freigeben</h3>
                <p>Du erhältst einen Vorschlag zu Ausführung, Preis und Zeitrahmen. Erst nach Freigabe geht es weiter.</p>
            </article>
            <article class="process-card">
                <span class="process-number">04</span>
                <h3>Druck &amp; Übergabe</h3>
                <p>Das Bauteil wird gefertigt und auf die vereinbarten Anforderungen geprüft. Die Übergabe wird abgestimmt.</p>
            </article>
        </div>
    </div>

    <section id="content4">
        <div class="content4-intro">
            
            <h2>Starke Ergebnisse starten<br>mit klaren<br>Anforderungen.</h2>
            <p>Damit dein Bauteil zuverlässig funktioniert, klären wir die wichtigsten Details bereits vor der Angebotserstellung.</p>
        </div>
        <div class="content4-checks">
            <article class="check-item">
                <span class="check-icon" aria-hidden="true"><i class="bi bi-check2"></i></span>
                <div>
                    <h3>Form &amp; Maßhaltigkeit</h3>
                    <p>Wandstärken, Überhänge und Toleranzen wirken sich auf das Ergebnis aus. Besondere Maße bitte hervorheben.</p>
                </div>
            </article>
            <article class="check-item">
                <span class="check-icon" aria-hidden="true"><i class="bi bi-check2"></i></span>
                <div>
                    <h3>Verwendung &amp; Belastung</h3>
                    <p>Teile können Wärme, Feuchtigkeit oder Kräften ausgesetzt sein. Beschreibe deshalb den geplanten Einsatz möglichst genau.</p>
                </div>
            </article>
            <article class="check-item">
                <span class="check-icon" aria-hidden="true"><i class="bi bi-check2"></i></span>
                <div>
                    <h3>Finish &amp; Ausführung</h3>
                    <p>Schichtlinien und Nachbearbeitung beeinflussen die Oberfläche. Wir wählen Ausrichtung und Finish passend zu deinem Projekt.</p>
                </div>
            </article>
        </div>
    </section>

  <div class="container" id="content5">
  <div class="row align-items-start">

    <!-- Linke Seite: Text -->
    <div class="col-12 col-md-6">
      <h2>Du möchtest ein Bauteil drucken?</h2>
      <p>Schicke uns ein Bild oder eine Skizze deines Wunsches und wir machen es möglich.</p>
      <p>Füll das Formular auf der rechten Seite aus, oder schreibe uns direkt auf
         <a href="mailto:info@print3d.at">info@print3d.at</a></p>

         <div class="bild3">
            <img src="img/bspbild3.jpg" alt="Beispielbild3" class="img-fluid mt-4" id="bspbild3">
        </div>
    </div>
           <div class="col-12 col-md-6">
             <form class="row g-3 needs-validation" novalidate id="formular">
               <div class="mb-3">
                <label for="formFile" class="form-label">Gib deine Datei an</label>
                <input class="form-control" type="file" id="formFile" aria-describedby="inputGroupPrepend2" required>
                </div>
              <div class="row mb-3">
                <div class="col-md-6">
                    <label for="vorname" class="form-label">Name</label>
                    <input type="text" class="form-control" id="vorname" placeholder="Max" aria-describedby="inputGroupPrepend2" required>
                </div>
                <div class="col-md-6">
                    <label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" id="nachname" placeholder="Mustermann" aria-describedby="inputGroupPrepend2" required>
                </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Telefonnummer</label>
                    <input type="tel" class="form-control" id="exampleFormControlInput1" placeholder="+43 123 456789" aria-describedby="inputGroupPrepend2" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Was hast du für ein Wunschteil?</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                <div class="col-12">
                    <button class="btnsubmit" type="submit">Abschicken</button>
                </div>  
            </form>
        </div>
    </div>
  </div>
        
    <?php include 'footer.php'; ?>
</body>
</html>