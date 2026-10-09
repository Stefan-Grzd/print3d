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
    <title>Chat | Print3d</title>
    <style>
        .chat-page {
            width: min(1180px, calc(100% - 2rem));
            min-height: 680px;
            margin: 3rem auto 5rem;
            display: grid;
            grid-template-columns: 320px minmax(0, 1fr);
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 1.25rem;
            box-shadow: 0 1.5rem 3rem rgba(47, 18, 82, 0.2);
        }

        .chat-sidebar {
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: #fafafa;
            border-right: 1px solid #ececf0;
        }

        .chat-sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 1.25rem 1rem;
        }

        .chat-sidebar-header h1 {
            margin: 0;
            color: #20202a;
            font-size: 1.35rem;
            font-weight: 700;
        }

        .chat-icon-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            color: #5b21b6;
            background: transparent;
            border: 0;
            border-radius: 50%;
            font-size: 1.25rem;
        }

        .chat-icon-button:hover,
        .chat-icon-button:focus-visible {
            color: #ffffff;
            background: #d946ef;
        }

        .chat-search {
            margin: 0 1.25rem 1rem;
            position: relative;
        }

        .chat-search i {
            position: absolute;
            top: 0.7rem;
            left: 0.8rem;
            color: #858594;
        }

        .chat-search input {
            width: 100%;
            padding: 0.65rem 0.75rem 0.65rem 2.25rem;
            color: #292936;
            background: #f0f0f3;
            border: 1px solid transparent;
            border-radius: 1.25rem;
            outline: 0;
        }

        .chat-search input:focus {
            border-color: #c026d3;
            background: #ffffff;
        }

        .chat-tabs {
            display: flex;
            gap: 1.25rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid #ececf0;
        }

        .chat-tab {
            padding: 0.75rem 0 0.65rem;
            color: #858594;
            background: transparent;
            border: 0;
            border-bottom: 2px solid transparent;
            font-weight: 600;
        }

        .chat-tab.active {
            color: #5b21b6;
            border-bottom-color: #c026d3;
        }

        .chat-list {
            padding: 0.5rem;
            overflow-y: auto;
        }

        .chat-contact {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 0.75rem;
            padding: 0.8rem;
            color: #252532;
            text-align: left;
            background: transparent;
            border: 0;
            border-radius: 0.75rem;
        }

        .chat-contact:hover,
        .chat-contact.active {
            background: #f0e8fa;
        }

        .chat-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 2.8rem;
            width: 2.8rem;
            height: 2.8rem;
            color: #ffffff;
            background: linear-gradient(135deg, #5b21b6, #d946ef);
            border-radius: 50%;
            font-weight: 700;
        }

        .chat-contact-copy {
            min-width: 0;
        }

        .chat-contact-copy strong,
        .chat-contact-copy span {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .chat-contact-copy strong {
            font-size: 0.9rem;
        }

        .chat-contact-copy span {
            margin-top: 0.2rem;
            color: #858594;
            font-size: 0.75rem;
        }

        .chat-main {
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: #ffffff;
        }

        .chat-main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #ececf0;
        }

        .chat-main-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .chat-main-user strong {
            display: block;
            color: #20202a;
        }

        .chat-main-user span {
            display: block;
            margin-top: 0.15rem;
            color: #32a852;
            font-size: 0.75rem;
        }

        .chat-messages {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 0.75rem;
            padding: 2rem 1.5rem;
            overflow-y: auto;
            background: linear-gradient(180deg, #ffffff 0%, #fcf9ff 100%);
        }

        .chat-date {
            align-self: center;
            margin-bottom: 0.75rem;
            color: #9999a5;
            font-size: 0.75rem;
        }

        .chat-bubble {
            max-width: min(75%, 30rem);
            padding: 0.75rem 1rem;
            color: #ffffff;
            background: linear-gradient(135deg, #5b21b6, #c026d3);
            border-radius: 1rem 1rem 1rem 0.2rem;
            line-height: 1.45;
        }

        .chat-bubble.own {
            align-self: flex-end;
            color: #30203b;
            background: #f0e8fa;
            border-radius: 1rem 1rem 0.2rem 1rem;
        }

        .chat-time {
            display: block;
            margin-top: 0.3rem;
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.68rem;
            text-align: right;
        }

        .chat-bubble.own .chat-time {
            color: #8f76a2;
        }

        .chat-composer {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem 1.25rem;
            border-top: 1px solid #ececf0;
        }

        .chat-composer input {
            min-width: 0;
            flex: 1;
            padding: 0.75rem 1rem;
            color: #292936;
            background: #f5f5f7;
            border: 1px solid transparent;
            border-radius: 1.4rem;
            outline: 0;
        }

        .chat-composer input:focus {
            border-color: #c026d3;
            background: #ffffff;
        }

        .chat-send {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            color: #ffffff;
            background: #5b21b6;
            border: 0;
            border-radius: 50%;
        }

        .chat-send:hover,
        .chat-send:focus-visible {
            background: #d946ef;
        }

        @media (max-width: 700px) {
            .chat-page {
                width: calc(100% - 1rem);
                min-height: 620px;
                margin: 1rem auto 2rem;
                grid-template-columns: 1fr;
            }

            .chat-sidebar {
                max-height: 300px;
                border-right: 0;
                border-bottom: 1px solid #ececf0;
            }

            .chat-main-header {
                min-height: 68px;
                padding: 0.75rem 1rem;
            }

            .chat-messages {
                padding: 1.25rem 1rem;
            }

            .chat-composer {
                padding: 0.75rem 1rem 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php#startseite" id="logo">
                <img src="img/print3d-logo-lila-magenta-transparent.svg" alt="Print3d" height="40" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Navigation öffnen">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-pills justify-content-center w-100">
                    <li class="nav-item"><a class="nav-link" href="index.php#startseite">Startseite</a></li>
                    <li class="nav-item"><a class="nav-link" href="leistungen.php">Leistungen</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#shop">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#kontakt">Kontakt</a></li>
                </ul>
            </div>
            <div class="nav-actions">
                <a class="nav-action-link" href="#warenkorb" aria-label="Warenkorb" title="Warenkorb"><i class="bi bi-cart3" aria-hidden="true"></i></a>
                <a class="nav-action-link" href="#account" aria-label="Mein Account" title="Mein Account"><i class="bi bi-person-circle" aria-hidden="true"></i></a>
            </div>
        </div>
    </nav>

    <main class="chat-page" aria-label="Nachrichten">
        <aside class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h1>Nachrichten</h1>
                <button class="chat-icon-button" type="button" aria-label="Neue Nachricht"><i class="bi bi-pencil-square" aria-hidden="true"></i></button>
            </div>
            <label class="chat-search" for="chat-search-input">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input id="chat-search-input" type="search" placeholder="Suchen..." autocomplete="off">
            </label>
            <div class="chat-tabs" role="tablist" aria-label="Nachrichtenfilter">
                <button class="chat-tab active" type="button" role="tab" aria-selected="true">Chats</button>
                <button class="chat-tab" type="button" role="tab" aria-selected="false">Anfragen</button>
            </div>
            <div class="chat-list" id="chat-list">
                <button class="chat-contact active" type="button" data-name="Print3d Support">
                    <span class="chat-avatar">P3</span>
                    <span class="chat-contact-copy"><strong>Print3d Support</strong><span>Wie können wir helfen?</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Max Mustermann">
                    <span class="chat-avatar">MM</span>
                    <span class="chat-contact-copy"><strong>Max Mustermann</strong><span>Deine Anfrage ist angekommen.</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Julia Weber">
                    <span class="chat-avatar">JW</span>
                    <span class="chat-contact-copy"><strong>Julia Weber</strong><span>Aktiv vor 10 Min.</span></span>
                </button>
            </div>
        </aside>

        <section class="chat-main">
            <header class="chat-main-header">
                <div class="chat-main-user">
                    <span class="chat-avatar">P3</span>
                    <div><strong>Print3d Support</strong><span>Online</span></div>
                </div>
                <button class="chat-icon-button" type="button" aria-label="Weitere Optionen"><i class="bi bi-three-dots" aria-hidden="true"></i></button>
            </header>
            <div class="chat-messages" id="chat-messages" aria-live="polite">
                <span class="chat-date">Heute</span>
                <div class="chat-bubble">Hallo! Schön, dass du da bist. Wie können wir dir bei deinem 3D-Druck-Projekt helfen?<span class="chat-time">10:24</span></div>
                <div class="chat-bubble own">Ich möchte gerne ein individuelles Bauteil anfragen.<span class="chat-time">10:26</span></div>
                <div class="chat-bubble">Sehr gerne! Schick uns einfach deine Idee, Maße oder eine Datei. Wir melden uns so schnell wie möglich mit den nächsten Schritten.<span class="chat-time">10:27</span></div>
            </div>
            <form class="chat-composer" id="chat-form">
                <button class="chat-icon-button" type="button" aria-label="Datei anhängen"><i class="bi bi-paperclip" aria-hidden="true"></i></button>
                <input id="chat-input" type="text" placeholder="Nachricht schreiben..." autocomplete="off" required>
                <button class="chat-send" type="submit" aria-label="Nachricht senden"><i class="bi bi-send-fill" aria-hidden="true"></i></button>
            </form>
        </section>
    </main>

    <script>
        const chatForm = document.querySelector("#chat-form");
        const chatInput = document.querySelector("#chat-input");
        const chatMessages = document.querySelector("#chat-messages");
        const searchInput = document.querySelector("#chat-search-input");

        chatForm.addEventListener("submit", (event) => {
            event.preventDefault();
            const message = chatInput.value.trim();

            if (!message) {
                return;
            }

            const bubble = document.createElement("div");
            bubble.className = "chat-bubble own";
            bubble.append(document.createTextNode(message));

            const time = document.createElement("span");
            time.className = "chat-time";
            time.textContent = new Date().toLocaleTimeString("de-DE", { hour: "2-digit", minute: "2-digit" });
            bubble.append(time);
            chatMessages.append(bubble);
            chatInput.value = "";
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        searchInput.addEventListener("input", () => {
            const searchTerm = searchInput.value.trim().toLowerCase();
            document.querySelectorAll(".chat-contact").forEach((contact) => {
                contact.hidden = !contact.dataset.name.toLowerCase().includes(searchTerm);
            });
        });

        document.querySelectorAll(".chat-contact").forEach((contact) => {
            contact.addEventListener("click", () => {
                document.querySelector(".chat-contact.active")?.classList.remove("active");
                contact.classList.add("active");
            });
        });

        document.querySelectorAll(".chat-tab").forEach((tab) => {
            tab.addEventListener("click", () => {
                document.querySelector(".chat-tab.active")?.classList.remove("active");
                document.querySelector(".chat-tab[aria-selected='true']")?.setAttribute("aria-selected", "false");
                tab.classList.add("active");
                tab.setAttribute("aria-selected", "true");
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
