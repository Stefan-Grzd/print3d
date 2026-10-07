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

const chatPage = document.querySelector(".chat-page");

if (chatPage) {
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
