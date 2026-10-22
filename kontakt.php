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

    <main class="contact-page">
        <header class="kontakt">
            <h1>Frage gefällig? Zöger nicht, <span class="highlight">kontaktiere uns!</span></h1>
        </header>

        <div class="contact-layout">
            <section class="contact-details" aria-labelledby="contact-details-title">
                <b class="titel-deko" id="contact-details-title">Unsere Kontaktdaten:</b>
                <p><i class="bi bi-geo-alt"></i> Edmund-Freibauer Promenade 1 <br> 2130 Mistelbach, Österreich</p>
                <p><i class="bi bi-telephone"></i> +43 123 456789</p>
                <p><i class="bi bi-envelope"></i> <a href="mailto:info@print3d.at">info@print3d.at</a></p>
            </section>

            <section class="contact-form-column">
                <form class="row g-3 needs-validation" novalidate id="formular">
                <b class="form-title">Fülle mich aus<i id="form-arrow"class="bi bi-arrow-down"></i></b>
              <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="vorname" placeholder="Vorname*" aria-describedby="inputGroupPrepend2" required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="nachname" placeholder="Nachname*" aria-describedby="inputGroupPrepend2" required>
                </div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Betreff*" required>
                </div>  
                <div class="mb-3">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email*" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Deine Nachricht*" required></textarea>
                    </div>
                <div class="col-12">
                    <button class="btnsubmit" type="submit">Abschicken</button>
                </div>  
                </form>
            </section>
        </div>
    </main>
      
      <?php include 'footer.php'; ?>
</body>
</html>