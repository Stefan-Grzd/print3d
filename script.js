/*Dark Mode Toggle */
const root = document.documentElement;
const toggle = document.getElementById("themeToggle");
const themeLogo = document.getElementById("themeLogo");

function applyTheme(theme) {
    root.setAttribute("data-theme", theme);
    root.setAttribute("data-bs-theme", theme);
    localStorage.setItem("theme", theme);
    if (themeLogo) {
        themeLogo.src = theme === "dark"
            ? "img/print3d-logo-navbar-weiss.svg"
            : "img/print3d-logo-lila-magenta-transparent.svg";
    }
    const icon = toggle?.querySelector("i");
    if (icon) icon.className = theme === "dark" ? "bi bi-sun" : "bi bi-moon-stars";
}

// gespeicherte Wahl oder Systemeinstellung
const saved = localStorage.getItem("theme");
const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
applyTheme(saved || (prefersDark ? "dark" : "light"));

toggle?.addEventListener("click", () => {
    applyTheme(root.getAttribute("data-theme") === "dark" ? "light" : "dark");
});


const materialItems = document.querySelectorAll("#leistungen-content2 .list-group-item");
const materialPopover = document.querySelector("#leistungen-content2 .material-popover");

if (materialItems.length > 0 && materialPopover) {
    const materialTitle = materialPopover.querySelector("h4");
    const materialInfo = materialPopover.querySelector("p");

    function hideMaterial() {
        materialPopover.setAttribute("aria-hidden", "true");
        materialPopover.classList.remove("is-visible");
        materialPopover.style.setProperty("opacity", "0", "important");
        materialPopover.style.setProperty("transform", "translateX(-0.5rem)", "important");
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
        materialPopover.style.setProperty("opacity", "1", "important");
        materialPopover.style.setProperty("transform", "translateX(0)", "important");
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
}

const leistungenList = document.querySelector(".leistungen-content-aufzaehlung");

if (leistungenList) {
    const leistungenItems = leistungenList.querySelectorAll(".leistungen-content-aufzaehlung-item");
    const leistungenCounters = leistungenList.querySelectorAll(".leistungen-counter");

    function animateCounter(counter) {
        const target = Number.parseInt(counter.dataset.target, 10);
        const suffix = counter.dataset.suffix || "";
        const duration = 3500;
        const start = performance.now();

        if (!Number.isFinite(target)) {
            counter.textContent = `0${suffix}`;
            return;
        }

        function updateCounter(timestamp) {
            const progress = Math.min((timestamp - start) / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            counter.textContent = `${Math.floor(easedProgress * target)}${suffix}`;

            if (progress < 1) {
                window.requestAnimationFrame(updateCounter);
            }
        }

        window.requestAnimationFrame(updateCounter);
    }

    function startCounters() {
        leistungenItems.forEach((item, index) => {
            window.setTimeout(() => {
                item.classList.add("is-visible");
                animateCounter(leistungenCounters[index]);
            }, index * 450);
        });
    }

    if ("IntersectionObserver" in window) {
        const leistungenObserver = new IntersectionObserver((entries, observer) => {
            if (!entries.some((entry) => entry.isIntersecting)) return;

            startCounters();
            observer.disconnect();
        }, { threshold: 0.25 });

        leistungenObserver.observe(leistungenList);
    } else {
        startCounters();
    }
}
/* Chat */

const chatPage = document.querySelector(".chat-page");

if (chatPage && document.querySelector("#chatList")) {
    const userRole = "unternehmen";
    const userId = 5;
    const placeholderAvatar = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64' fill='none' stroke='%239ca3af' stroke-width='3'%3E%3Cpath d='M52 58v-5a12 12 0 0 0-12-12H24a12 12 0 0 0-12 12v5'/%3E%3Ccircle cx='32' cy='21' r='10'/%3E%3C/svg%3E";
    const sidebar = document.querySelector("#sidebar");
    const chatList = document.querySelector("#chatList");
    const messages = document.querySelector("#messagesContainer");
    const messageInput = document.querySelector("#messageInput");
    const sendButton = document.querySelector("#sendBtn");
    const activeAvatar = document.querySelector("#activeAvatar");
    const activeAvatarImage = document.querySelector("#activeAvatarImg");
    const activeName = document.querySelector("#activeName");
    const activeSub = document.querySelector("#activeSub");
    const profileModal = document.querySelector("#profileModalBackdrop");
    const profileAvatar = document.querySelector("#profileAvatar");
    const profileName = document.querySelector("#profileName");
    const profileRole = document.querySelector("#profileRole");
    const profileBio = document.querySelector("#profileBio");
    const closeChatButton = document.querySelector("#closeChatBtn");
    const closeProfileButton = document.querySelector("#closeProfileBtn");

    let currentKoopId = null;
    let currentPartner = null;
    let pollInterval = null;

    function getAvatar(source) {
        return source || placeholderAvatar;
    }

    function createImage(source, className, alt = "") {
        const image = document.createElement("img");
        image.src = getAvatar(source);
        image.alt = alt;
        image.className = className;
        return image;
    }

    function createConversationItem(conversation, isActive) {
        const item = document.createElement("button");
        item.type = "button";
        item.className = `conversation-item${isActive ? " is-active" : ""}`;
        item.dataset.koopId = conversation.koop_id;
        item.dataset.partnerId = conversation.partner_id;
        item.dataset.partnerRole = conversation.partner_role;
        item.dataset.partnerName = conversation.partner_name;
        item.dataset.partnerAvatar = getAvatar(conversation.partner_avatar);

        const avatar = createImage(conversation.partner_avatar, "conversation-avatar", conversation.partner_name);
        const content = document.createElement("span");
        content.className = "conversation-content";

        const header = document.createElement("span");
        header.className = "conversation-header";
        const name = document.createElement("strong");
        name.textContent = conversation.partner_name;
        const time = document.createElement("time");
        time.textContent = conversation.last_time || "";
        header.append(name, time);

        const preview = document.createElement("span");
        preview.className = "conversation-preview";
        preview.textContent = conversation.last_message || "Noch keine Nachrichten";
        content.append(header, preview);
        item.append(avatar, content);
        item.addEventListener("click", () => selectConversation(item));
        return item;
    }

    async function loadConversations() {
        try {
            const response = await fetch(`chat_conversations.php?t=${Date.now()}`);
            if (!response.ok) throw new Error(`Unterhaltungen konnten nicht geladen werden (${response.status}).`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);

            chatList.replaceChildren();
            data.forEach((conversation) => {
                const isActive = Number(conversation.koop_id) === Number(currentKoopId);
                chatList.appendChild(createConversationItem(conversation, isActive));
            });
        } catch (error) {
            console.error("Chat-Unterhaltungen:", error);
        }
    }

    function selectConversation(item) {
        currentKoopId = item.dataset.koopId;
        currentPartner = {
            id: item.dataset.partnerId,
            role: item.dataset.partnerRole,
            name: item.dataset.partnerName,
            avatar: item.dataset.partnerAvatar
        };

        activeName.textContent = currentPartner.name;
        activeSub.textContent = currentPartner.role === "unternehmen" ? "Unternehmen" : "Influencer";
        activeAvatarImage.src = currentPartner.avatar;
        activeAvatarImage.alt = currentPartner.name;
        activeAvatar.hidden = false;
        activeAvatar.onclick = () => openProfile(currentPartner.id, currentPartner.role);

        loadMessages();
        loadConversations();
        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(loadMessages, 3000);

        if (window.innerWidth <= 768) sidebar.classList.add("is-hidden");
    }

    function createMessage(message) {
        const isMine = message.sender_role === userRole && Number(message.sender_id) === userId;
        const row = document.createElement("div");
        row.className = `message-row${isMine ? " is-mine" : ""}`;

        if (!isMine) {
            const avatar = createImage(message.sender_avatar, "message-avatar", message.sender_name || "Profil");
            avatar.addEventListener("click", () => openProfile(message.sender_id, message.sender_role));
            row.appendChild(avatar);
        }

        const body = document.createElement("div");
        body.className = "message-body";
        const bubble = document.createElement("p");
        bubble.className = `message-bubble ${isMine ? "bubble-me" : "bubble-other"}`;
        bubble.textContent = message.nachricht;
        const time = document.createElement("time");
        time.textContent = message.zeit || "";
        body.append(bubble, time);
        row.appendChild(body);
        return row;
    }

    async function loadMessages() {
        if (!currentKoopId) return;
        try {
            const response = await fetch(`chat_messages.php?koop_id=${encodeURIComponent(currentKoopId)}&t=${Date.now()}`);
            if (!response.ok) throw new Error(`Nachrichten konnten nicht geladen werden (${response.status}).`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);

            const shouldScroll = messages.scrollTop + messages.clientHeight >= messages.scrollHeight - 50;
            messages.replaceChildren();
            data.forEach((message) => messages.appendChild(createMessage(message)));
            if (shouldScroll) messages.scrollTop = messages.scrollHeight;
        } catch (error) {
            console.error("Chat-Nachrichten:", error);
        }
    }

    async function sendMessage() {
        if (!currentKoopId) return;
        const text = messageInput.value.trim();
        if (!text) return;

        messageInput.disabled = true;
        try {
            const response = await fetch("chat_senden.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ koop_id: currentKoopId, text })
            });
            if (!response.ok) throw new Error(`Nachricht konnte nicht gesendet werden (${response.status}).`);
            const data = await response.json();
            if (data.error || !data.success) throw new Error(data.error || "Nachricht konnte nicht gesendet werden.");
            messageInput.value = "";
            await Promise.all([loadMessages(), loadConversations()]);
        } catch (error) {
            console.error("Nachricht senden:", error);
        } finally {
            messageInput.disabled = false;
            messageInput.focus();
        }
    }

    async function openProfile(id, role) {
        try {
            const response = await fetch(`chat_profile.php?role=${encodeURIComponent(role)}&id=${encodeURIComponent(id)}`);
            if (!response.ok) throw new Error(`Profil konnte nicht geladen werden (${response.status}).`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);

            profileAvatar.src = getAvatar(data.avatar);
            profileAvatar.alt = data.name || "Profil";
            profileName.textContent = data.name || "Unbekannt";
            profileRole.textContent = data.role === "unternehmen" ? "Unternehmen" : "Influencer";
            profileBio.textContent = data.bio || "Keine Beschreibung vorhanden.";
            profileModal.hidden = false;
        } catch (error) {
            console.error("Chat-Profil:", error);
        }
    }

    function closeProfileModal() {
        profileModal.hidden = true;
    }

    sendButton.addEventListener("click", sendMessage);
    messageInput.addEventListener("keydown", (event) => {
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });
    closeChatButton.addEventListener("click", () => sidebar.classList.remove("is-hidden"));
    closeProfileButton.addEventListener("click", closeProfileModal);
    profileModal.addEventListener("click", (event) => {
        if (event.target === profileModal) closeProfileModal();
    });

    activeAvatar.hidden = true;
    loadConversations();
}

const simpleChatPage = document.querySelector(".chat-page");

if (simpleChatPage && !document.querySelector("#chatList")) {
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
        if (!message) return;

        const time = new Date().toLocaleTimeString("de-DE", { hour: "2-digit", minute: "2-digit" });
        const bubble = document.createElement("div");
        bubble.className = "chat-bubble own";
        bubble.append(document.createTextNode(message));

        const timeElement = document.createElement("span");
        timeElement.className = "chat-time";
        timeElement.textContent = time;
        bubble.append(timeElement);
        chatMessages.append(bubble);
        chats[activeChatId].messages.push([message, true, time]);
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
}


/* Login/Register Modal */
const container = document.getElementById('container');
if (container) {
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });
}

/* Warenkorb */
const cartStorageKey = "print3d-cart";
let cartItems = [];

try {
    const storedCart = JSON.parse(localStorage.getItem(cartStorageKey) || "[]");
    if (Array.isArray(storedCart)) cartItems = storedCart;
} catch (error) {
    console.error("Warenkorb konnte nicht geladen werden:", error);
}

const cartDrawer = document.querySelector("#cartDrawer");
const cartBackdrop = document.querySelector("#cartBackdrop");
const cartItemsElement = document.querySelector("#cartItems");
const cartEmpty = document.querySelector("#cartEmpty");
const cartDrawerTotal = document.querySelector("#cartDrawerTotal");
const cartFeedback = document.querySelector("#cartFeedback");
const cartCount = document.querySelector("#cartCount");
const cartTrigger = document.querySelector(".cart-trigger");
const cartClose = document.querySelector("#cartClose");
const cartLoginPopover = document.querySelector("#cartLoginPopover");

function showCartLoginPopover(anchor = cartTrigger) {
    const popover = anchor?.closest(".product-buy")?.querySelector(".product-login-popover")
        || cartLoginPopover;
    if (!popover) return;
    popover.classList.add("is-visible");
    window.clearTimeout(showCartLoginPopover.timeout);
    showCartLoginPopover.timeout = window.setTimeout(() => {
        popover.classList.remove("is-visible");
    }, 4500);
}

document.addEventListener("click", (event) => {
    const target = event.target instanceof Element ? event.target : null;
    if (!target?.closest(".cart-login-popover, .product-login-popover, .cart-trigger, .add-to-cart")) {
        document.querySelectorAll(".cart-login-popover.is-visible, .product-login-popover.is-visible")
            .forEach((popover) => popover.classList.remove("is-visible"));
    }
});

function formatPrice(value) {
    return `${value.toFixed(2).replace(".", ",")} €`;
}

function saveCart() {
    localStorage.setItem(cartStorageKey, JSON.stringify(cartItems));
}

function updateCartBadge() {
    const count = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    if (cartCount) {
        cartCount.textContent = count;
        cartCount.hidden = count === 0;
    }
}

function renderCart() {
    if (!cartItemsElement || !cartEmpty || !cartDrawerTotal) return;

    cartItemsElement.replaceChildren();
    const hasItems = cartItems.length > 0;
    cartEmpty.hidden = hasItems;
    cartItemsElement.hidden = !hasItems;

    let total = 0;
    cartItems.forEach((item) => {
        total += item.price * item.quantity;

        const entry = document.createElement("article");
        entry.className = "cart-item";
        entry.innerHTML = `
            <img src="${item.image}" alt="">
            <div class="cart-item-content">
                <h3>${item.name} <span class="cart-item-unit-price">(${formatPrice(item.price)} / Stück)</span></h3>
                <strong>${formatPrice(item.price * item.quantity)}</strong>
                <div class="cart-quantity" aria-label="Menge für ${item.name}">
                    <button type="button" data-cart-action="decrease" data-cart-name="${item.name}" aria-label="${item.name} entfernen">−</button>
                    <span>${item.quantity}</span>
                    <button type="button" data-cart-action="increase" data-cart-name="${item.name}" aria-label="${item.name} hinzufügen">+</button>
                </div>
            </div>
            <button class="cart-item-remove" type="button" data-cart-action="remove" data-cart-name="${item.name}" aria-label="${item.name} aus dem Warenkorb entfernen">
                <i class="bi bi-trash3" aria-hidden="true"></i>
            </button>
        `;
        cartItemsElement.appendChild(entry);
    });

    cartDrawerTotal.textContent = formatPrice(total);
    updateCartBadge();
}

function addToCart(button) {
    const name = button.dataset.product;
    const price = Number(button.dataset.price);
    const image = button.closest(".product-card")?.querySelector(".product-image img")?.src || "img/bspbild1.jpeg";
    const existingItem = cartItems.find((item) => item.name === name);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cartItems.push({ name, price, image, quantity: 1 });
    }

    saveCart();
    renderCart();
    if (cartFeedback) {
        cartFeedback.textContent = `${name} wurde hinzugefügt`;
        cartFeedback.classList.add("is-visible");
    }
    setCartOpen(true);
    window.clearTimeout(addToCart.closeTimeout);
    addToCart.closeTimeout = window.setTimeout(() => {
        setCartOpen(false);
        cartFeedback?.classList.remove("is-visible");
    }, 3200);
    button.textContent = "Hinzugefügt";
    window.setTimeout(() => {
        button.textContent = "In den Warenkorb";
    }, 1200);
}

function setCartOpen(isOpen) {
    if (!cartDrawer || !cartBackdrop || !cartTrigger) return;
    cartDrawer.classList.toggle("is-open", isOpen);
    cartDrawer.setAttribute("aria-hidden", String(!isOpen));
    cartBackdrop.hidden = !isOpen;
    cartTrigger.setAttribute("aria-expanded", String(isOpen));
    document.body.classList.toggle("cart-is-open", isOpen);
}

cartTrigger?.addEventListener("click", () => {
    if (cartTrigger.dataset.authenticated !== "true") {
        cartTrigger.setAttribute("aria-expanded", "false");
        showCartLoginPopover();
        cartTrigger.blur();
        return;
    }
    setCartOpen(true);
});
cartClose?.addEventListener("click", () => setCartOpen(false));
cartBackdrop?.addEventListener("click", () => setCartOpen(false));

cartItemsElement?.addEventListener("click", (event) => {
    const button = event.target.closest("[data-cart-action]");
    if (!button) return;

    const name = button.dataset.cartName;
    const item = cartItems.find((entry) => entry.name === name);
    if (!item) return;

    if (button.dataset.cartAction === "increase") item.quantity += 1;
    if (button.dataset.cartAction === "decrease") item.quantity -= 1;
    if (button.dataset.cartAction === "remove" || item.quantity <= 0) {
        cartItems = cartItems.filter((entry) => entry.name !== name);
    }

    saveCart();
    renderCart();
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") setCartOpen(false);
});

renderCart();

/* Shop */
const shopPage = document.querySelector(".shop-page");

if (shopPage) {
    const productSearch = document.querySelector("#productSearch");
    const productFilter = document.querySelector("#productFilter");
    const products = document.querySelectorAll(".product-card");
    const emptyState = document.querySelector("#shopEmpty");
    const cartMessage = document.querySelector("#cartMessage");
    const cartTotal = document.querySelector("#cartTotal");

    function updateShopSummary() {
        const count = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        const total = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
        if (cartMessage) {
            cartMessage.textContent = count > 0
                ? `${count} ${count === 1 ? "Produkt" : "Produkte"} ausgewählt`
                : "Noch keine Produkte ausgewählt";
        }
        if (cartTotal) {
            cartTotal.textContent = formatPrice(total);
        }
    }

    function filterProducts() {
        const search = productSearch.value.toLowerCase().trim();
        const category = productFilter.value;
        let visibleProducts = 0;

        products.forEach((product) => {
            const matchesSearch = product.dataset.name.toLowerCase().includes(search);
            const matchesCategory = category === "all" || product.dataset.category === category;
            const isVisible = matchesSearch && matchesCategory;
            product.hidden = !isVisible;
            if (isVisible) visibleProducts += 1;
        });

        emptyState.hidden = visibleProducts > 0;
    }

    productSearch.addEventListener("input", filterProducts);
    productFilter.addEventListener("change", filterProducts);
    updateShopSummary();

    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", () => {
            if (cartTrigger?.dataset.authenticated !== "true") {
                showCartLoginPopover(button);
                return;
            }
            addToCart(button);
            updateShopSummary();
        });
    });
}
const leistungCarousel = document.querySelector("#carouselExampleContent");
    const leistungIndicators = document.querySelectorAll(".leistung-carousel-indicator");

    if (leistungCarousel && leistungIndicators.length > 0) {
        leistungCarousel.addEventListener("slid.bs.carousel", (event) => {
            leistungIndicators.forEach((indicator, index) => {
                indicator.classList.toggle("is-active", index === event.to);
            });
        });
    }
