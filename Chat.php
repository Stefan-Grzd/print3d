<?php
// Verbindungsdatei einbinden
require_once 'db.php';

// Beispiel: Daten aus einer Tabelle "user" auslesen
$stmt = $pdo->query("SELECT * FROM kunde");
$users = $stmt->fetchAll();

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
    <title>Chat | Print3d</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" id="logo">
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="Chat.php">Chat</a></li>
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
                <button class="chat-contact active" type="button" data-name="Print3d Support" data-chat="support">
                    <span class="chat-avatar">P3</span>
                    <span class="chat-contact-copy"><strong>Print3d Support</strong><span>Wie können wir helfen?</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Max Mustermann" data-chat="max">
                    <span class="chat-avatar">MM</span>
                    <span class="chat-contact-copy"><strong>Max Mustermann</strong><span>Deine Anfrage ist angekommen.</span></span>
                </button>
                <button class="chat-contact" type="button" data-name="Julia Weber" data-chat="julia">
                    <span class="chat-avatar">JW</span>
                    <span class="chat-contact-copy"><strong>Julia Weber</strong><span>Aktiv vor 10 Min.</span></span>
                </button>
            </div>
        </aside>

        <section class="chat-main">
            <header class="chat-main-header">
                <div class="chat-main-user">
                    <span class="chat-avatar" id="chat-main-avatar">P3</span>
                    <div><strong id="chat-main-name">Print3d Support</strong><span id="chat-main-status">Online</span></div>
                </div>
                <button class="chat-icon-button" type="button" aria-label="Weitere Optionen"><i class="bi bi-three-dots" aria-hidden="true"></i></button>
            </header>
            <div class="chat-messages" id="chat-messages" aria-live="polite"></div>
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
        const chatMainAvatar = document.querySelector("#chat-main-avatar");
        const chatMainName = document.querySelector("#chat-main-name");
        const chatMainStatus = document.querySelector("#chat-main-status");

        const chats = {
            support: {
                name: "Print3d Support",
                avatar: "P3",
                status: "Online",
                messages: [
                    ["Hallo! Schön, dass du da bist. Wie können wir dir bei deinem 3D-Druck-Projekt helfen?", false, "10:24"],
                    ["Ich möchte gerne ein individuelles Bauteil anfragen.", true, "10:26"],
                    ["Sehr gerne! Schick uns einfach deine Idee, Maße oder eine Datei. Wir melden uns so schnell wie möglich mit den nächsten Schritten.", false, "10:27"]
                ]
            },
            max: {
                name: "Max Mustermann",
                avatar: "MM",
                status: "Zuletzt online vor 2 Std.",
                messages: [
                    ["Hallo, ich habe eine Frage zu meiner Anfrage.", false, "09:42"],
                    ["Gerne, worum geht es genau?", true, "09:45"]
                ]
            },
            julia: {
                name: "Julia Weber",
                avatar: "JW",
                status: "Online",
                messages: [
                    ["Ist mein Bauteil schon in Bearbeitung?", false, "Gestern"],
                    ["Wir prüfen die Datei gerade und melden uns gleich bei dir.", true, "Gestern"]
                ]
            }
        };

        let activeChatId = "support";

        function renderChat(chatId) {
            const chat = chats[chatId];
            activeChatId = chatId;
            chatMainAvatar.textContent = chat.avatar;
            chatMainName.textContent = chat.name;
            chatMainStatus.textContent = chat.status;
            chatMessages.replaceChildren();

            const date = document.createElement("span");
            date.className = "chat-date";
            date.textContent = "Heute";
            chatMessages.append(date);

            chat.messages.forEach(([text, own, time]) => {
                const bubble = document.createElement("div");
                bubble.className = `chat-bubble${own ? " own" : ""}`;
                bubble.append(document.createTextNode(text));

                const timeElement = document.createElement("span");
                timeElement.className = "chat-time";
                timeElement.textContent = time;
                bubble.append(timeElement);
                chatMessages.append(bubble);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

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
            chats[activeChatId].messages.push([message, true, time.textContent]);
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
                renderChat(contact.dataset.chat);
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

        renderChat(activeChatId);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
