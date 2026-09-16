<!-- MISFITS Guest Chat -->
<div id="misfits-chat" class="misfits-chat-widget" aria-live="polite">
  <button id="chat-toggle" type="button" class="misfits-chat-toggle" aria-expanded="false" aria-controls="chat-panel">
    <span class="misfits-chat-icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 10h8M8 14h5m-9 6 1.7-3.4A8.97 8.97 0 0 1 4 10a8 8 0 1 1 16 0 8 8 0 0 1-8 8H9l-5 2Z" />
      </svg>
      <span class="misfits-chat-dot"></span>
      <span id="chat-count" class="misfits-chat-count">0</span>
    </span>
  </button>

  <section id="chat-panel" class="misfits-chat-panel" aria-label="MISFITS guest chat">
    <header class="misfits-chat-header">
      <div>
        <div class="misfits-chat-title"><span></span>MISFITS CHAT</div>
        <p>Ask about rides, routes, and events.</p>
      </div>
      <button id="chat-close" type="button" class="misfits-chat-close" aria-label="Close chat">&times;</button>
    </header>

    <div id="chat-messages" class="misfits-chat-messages">
      <div class="misfits-chat-welcome">
        <strong>MISFITS CHAT</strong>
        Welcome, rider. This is a shared group conversation. Your messages appear on the right; other riders' and
        MISFITS replies appear on the left.
      </div>
    </div>

    <div class="misfits-chat-form">
      <label for="chat-name">Nickname</label>
      <input id="chat-name" maxlength="60" autocomplete="nickname" placeholder="Your nickname">

      <div class="misfits-chat-compose">
        <textarea id="chat-message" rows="2" maxlength="500" placeholder="Write a message..."></textarea>
        <button id="chat-send" type="button" aria-label="Send message" disabled>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 14-7-5 14-2.5-5.5L5 12Z" />
          </svg>
        </button>
      </div>
      <p id="chat-status" class="misfits-chat-status"></p>
    </div>
  </section>
</div>

<style>
  #misfits-chat.misfits-chat-widget {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 99999;
    font-family: inherit;
  }

#misfits-chat .misfits-chat-toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 54px;
  height: 54px;
  padding: 0;
  border: 1px solid rgba(232, 88, 12, .45);
  border-radius: 50%;
  background: #17181c;
  color: #fff;
  box-shadow: 0 14px 35px rgba(0, 0, 0, .45);
  cursor: pointer;
  font-size: 13px;
  font-weight: 700;
  transition: .2s ease;
}

  #misfits-chat .misfits-chat-toggle:hover {
    background: #22242a;
    border-color: #e8580c;
    transform: translateY(-2px);
  }

  #misfits-chat .misfits-chat-icon {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    border-radius: 50%;
    background: #e8580c;
    color: #0e0f12;
  }

  #misfits-chat .misfits-chat-icon svg {
    width: 20px;
    height: 20px;
    stroke-width: 2;
  }

  #misfits-chat .misfits-chat-dot {
    position: absolute;
    top: 0;
    right: 0;
    width: 9px;
    height: 9px;
    border: 2px solid #17181c;
    border-radius: 50%;
    background: #f2a165;
  }

  #misfits-chat .misfits-chat-count {
    position: absolute;
    top: -7px;
    right: -7px;
    display: none;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 5px;
    border: 2px solid #17181c;
    border-radius: 999px;
    background: #e8580c;
    color: #fff;
    font-size: 9px;
    font-weight: 800;
    line-height: 1;
  }

  #misfits-chat .misfits-chat-count.is-visible {
    display: inline-flex;
  }

  #misfits-chat .misfits-chat-panel {
    position: absolute;
    right: 0;
    bottom: 66px;
    display: none;
    width: min(380px, calc(100vw - 30px));
    overflow: hidden;
    border: 1px solid #33363e;
    border-radius: 16px;
    background: #0e0f12;
    box-shadow: 0 24px 60px rgba(0, 0, 0, .6);
    z-index: 999999;
  }

  #misfits-chat.is-open .misfits-chat-panel {
    display: block;
  }

  #misfits-chat .misfits-chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid #22242a;
    background: #17181c;
  }

  #misfits-chat .misfits-chat-title {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .08em;
  }

  #misfits-chat .misfits-chat-title span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #e8580c;
  }

  #misfits-chat .misfits-chat-header p {
    margin: 3px 0 0;
    color: #9298a3;
    font-size: 10px;
  }

  #misfits-chat .misfits-chat-close {
    width: 32px;
    height: 32px;
    border: 0;
    border-radius: 8px;
    background: transparent;
    color: #9298a3;
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
  }

  #misfits-chat .misfits-chat-close:hover {
    background: #22242a;
    color: #fff;
  }

  #misfits-chat .misfits-chat-messages {
    height: 288px;
    max-height: 288px;
    padding: 16px;
    overflow-x: hidden;
    overflow-y: auto;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #4a5260 #0e0f12;
    background: #0e0f12;
  }

  #misfits-chat .misfits-chat-messages::-webkit-scrollbar {
    width: 6px;
  }

  #misfits-chat .misfits-chat-messages::-webkit-scrollbar-track {
    background: #0e0f12;
  }

  #misfits-chat .misfits-chat-messages::-webkit-scrollbar-thumb {
    border-radius: 999px;
    background: #4a5260;
  }

  #misfits-chat .misfits-chat-messages::-webkit-scrollbar-thumb:hover {
    background: #687384;
  }

  #misfits-chat .misfits-chat-welcome {
    max-width: 88%;
    margin-bottom: 10px;
    padding: 10px 12px;
    border: 1px solid #22242a;
    border-radius: 12px;
    background: #17181c;
    color: #c5c9d0;
    font-size: 12px;
    line-height: 1.5;
  }

  #misfits-chat .misfits-chat-welcome strong {
    display: block;
    margin-bottom: 3px;
    color: #e8580c;
    font-size: 10px;
    letter-spacing: .08em;
  }

  #misfits-chat .misfits-chat-message-row {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    width: 100%;
    margin-bottom: 14px;
  }

  #misfits-chat .misfits-chat-message-row.is-left {
    justify-content: flex-start;
  }

  #misfits-chat .misfits-chat-message-row.is-right {
    justify-content: flex-end;
  }

  #misfits-chat .misfits-chat-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 25px;
    height: 25px;
    flex: 0 0 25px;
    border-radius: 50%;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
  }

  #misfits-chat .misfits-chat-avatar.is-admin {
    background: #e8580c;
    color: #0e0f12;
  }

  #misfits-chat .misfits-chat-avatar.is-guest {
    background: #2f7dd1;
    color: #fff;
  }

  #misfits-chat .misfits-chat-avatar.is-other {
    background: #596273;
    color: #fff;
  }

  #misfits-chat .misfits-chat-message-wrap {
    display: flex;
    flex-direction: column;
    max-width: 78%;
  }

  #misfits-chat .misfits-chat-message-row.is-right .misfits-chat-message-wrap {
    align-items: flex-end;
  }

  #misfits-chat .misfits-chat-message-row.is-left .misfits-chat-message-wrap {
    align-items: flex-start;
  }

  #misfits-chat .misfits-chat-bubble {
    position: relative;
    max-width: 100%;
    padding: 8px 12px;
    border: 1px solid #33363e;
    border-radius: 16px;
    color: #fff;
    font-size: 12px;
    line-height: 1.45;
    overflow-wrap: anywhere;
  }

  #misfits-chat .misfits-chat-bubble.is-admin {
    border-color: #33363e;
    background: #17181c;
    color: #d7d9de;
    border-bottom-left-radius: 5px;
  }

  #misfits-chat .misfits-chat-bubble.is-owner {
    border-color: #2f7dd1;
    background: #2f7dd1;
    color: #fff;
    border-bottom-right-radius: 5px;
  }

  #misfits-chat .misfits-chat-bubble.is-other {
    border-color: #4a5260;
    background: #343a46;
    color: #f1f3f5;
    border-bottom-left-radius: 5px;
  }

  #misfits-chat .misfits-chat-message-row.is-right .misfits-chat-bubble.is-owner::after {
    content: "";
    position: absolute;
    right: -6px;
    bottom: -1px;
    width: 10px;
    height: 10px;
    background: #2f7dd1;
    clip-path: polygon(0 0, 100% 100%, 0 100%);
  }

  #misfits-chat .misfits-chat-message-row.is-left .misfits-chat-bubble.is-other::after,
  #misfits-chat .misfits-chat-message-row.is-left .misfits-chat-bubble.is-admin::after {
    content: "";
    position: absolute;
    left: -6px;
    bottom: -1px;
    width: 10px;
    height: 10px;
    background: #343a46;
    clip-path: polygon(0 100%, 100% 0, 100% 100%);
  }

  #misfits-chat .misfits-chat-message-row.is-left .misfits-chat-bubble.is-admin::after {
    background: #17181c;
  }

  #misfits-chat .misfits-chat-name {
    margin: 0 3px 3px;
    color: #9ca2ad;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
  }

  #misfits-chat .misfits-chat-name.is-admin {
    color: #e8580c;
  }

  #misfits-chat .misfits-chat-name:not(.is-admin) {
    color: #aeb5c0;
  }

  #misfits-chat .misfits-chat-message-text {
    margin: 0;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
  }

  #misfits-chat .misfits-chat-time {
    margin-top: 3px;
    padding: 0 3px;
    color: #6f7580;
    font-size: 8px;
    line-height: 1;
  }

  #misfits-chat .misfits-chat-time.is-right {
    text-align: right;
  }

  #misfits-chat .misfits-chat-time.is-left {
    text-align: left;
  }

  #misfits-chat .misfits-chat-empty {
    padding: 10px 12px;
    border: 1px solid #22242a;
    border-radius: 12px;
    background: #17181c;
    color: #777d88;
    font-size: 11px;
    text-align: center;
  }

  #misfits-chat .misfits-chat-form {
    padding: 12px;
    border-top: 1px solid #22242a;
    background: #17181c;
  }

  #misfits-chat .misfits-chat-form label {
    display: block;
    margin-bottom: 4px;
    color: #9298a3;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .15em;
  }

  #misfits-chat .misfits-chat-form input,
  #misfits-chat .misfits-chat-form textarea {
    box-sizing: border-box;
    width: 100%;
    border: 1px solid #33363e;
    border-radius: 8px;
    outline: none;
    background: #0e0f12;
    color: #fff;
    font-family: inherit;
    font-size: 12px;
  }

  #misfits-chat .misfits-chat-form input {
    height: 36px;
    padding: 0 10px;
    margin-bottom: 8px;
  }

  #misfits-chat .misfits-chat-form textarea {
    min-height: 42px;
    padding: 9px 10px;
    resize: none;
  }

  #misfits-chat .misfits-chat-form input:focus,
  #misfits-chat .misfits-chat-form textarea:focus {
    border-color: #e8580c;
  }

  #misfits-chat .misfits-chat-compose {
    display: flex;
    align-items: flex-end;
    gap: 8px;
  }

  #misfits-chat .misfits-chat-compose textarea {
    flex: 1;
  }

  #misfits-chat #chat-send {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    border: 0;
    border-radius: 8px;
    background: #e8580c;
    color: #0e0f12;
    cursor: pointer;
    transition: .2s ease;
  }

  #misfits-chat #chat-send:hover {
    background: #f2a165;
  }

  #misfits-chat #chat-send:disabled {
    background: #33363e;
    color: #777d88;
    opacity: 1;
    cursor: not-allowed;
  }

  #misfits-chat #chat-send svg {
    width: 17px;
    height: 17px;
    stroke-width: 2;
  }

  #misfits-chat .misfits-chat-status {
    min-height: 13px;
    margin: 6px 0 0;
    color: #777d88;
    font-size: 10px;
  }

  @media (max-width: 640px) {
    #misfits-chat.misfits-chat-widget {
      right: 12px;
      bottom: 12px;
    }

    #misfits-chat .misfits-chat-toggle {
      width: 52px;
      height: 52px;
      min-height: 52px;
      padding: 6px;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .5);
    }

    #misfits-chat .misfits-chat-label {
      display: none;
    }

    #misfits-chat .misfits-chat-icon {
      width: 40px;
      height: 40px;
    }

    #misfits-chat .misfits-chat-panel {
      position: fixed;
      left: 10px;
      right: 10px;
      bottom: 74px;
      width: auto;
      max-height: calc(100vh - 90px);
      border-radius: 14px;
    }

    #misfits-chat .misfits-chat-messages {
      height: min(42vh, 320px);
    }
  }
  /* Inline guest chat behavior. Kept inside the widget so InfinityFree does not need to serve a separate chat.js file. */
  
</style>

<script>
(function () {
  "use strict";

  var root = document.getElementById("misfits-chat");
  if (!root) return;

  var toggle = document.getElementById("chat-toggle");
  var close = document.getElementById("chat-close");
  var messages = document.getElementById("chat-messages");
  var nameInput = document.getElementById("chat-name");
  var messageInput = document.getElementById("chat-message");
  var sendButton = document.getElementById("chat-send");
  var status = document.getElementById("chat-status");
  var countBadge = document.getElementById("chat-count");
  var timer = null;
  var open = false;
  var myGuestId = localStorage.getItem("misfits_chat_guest_id") || "";

  if (!/^guest_[a-f0-9]{24}$/.test(myGuestId)) {
    var guestBytes = new Uint8Array(12);
    if (window.crypto && window.crypto.getRandomValues) {
      window.crypto.getRandomValues(guestBytes);
      myGuestId = "guest_" + Array.prototype.map.call(guestBytes, function (byte) {
        return ("0" + byte.toString(16)).slice(-2);
      }).join("");
    } else {
      myGuestId = "guest_" + Math.random().toString(16).slice(2, 14) + Date.now().toString(16);
      myGuestId = myGuestId.slice(0, 30);
    }
    localStorage.setItem("misfits_chat_guest_id", myGuestId);
  }

  /* Same-origin URLs: works locally and on InfinityFree without CORS. */
  var base = "<?= base_url(); ?>";
  var messagesUrl = base + "messages";
  var sendUrl = base + "send";

  nameInput.value = localStorage.getItem("misfits_chat_name") || "";

  function updateSendButton() {
    if (!sendButton) return;
    var hasMessage = messageInput.value.trim().length > 0;
    sendButton.disabled = !hasMessage;
    sendButton.setAttribute("aria-disabled", hasMessage ? "false" : "true");
  }

  function setStatus(text, error) {
    status.textContent = text || "";
    status.style.color = error ? "#f2604d" : "#777d88";
  }

  function escapeHtml(value) {
    var div = document.createElement("div");
    div.textContent = value == null ? "" : String(value);
    return div.innerHTML;
  }

  function updateCount(count) {
    if (!countBadge) return;
    count = Number(count) || 0;
    countBadge.textContent = count > 99 ? "99+" : String(count);
    countBadge.classList.toggle("is-visible", count > 0);
  }

  function formatChatTime(value) {
    if (!value) return "";
    var date = new Date(String(value).replace(" ", "T"));
    if (isNaN(date.getTime())) return "";
    return date.toLocaleTimeString([], { hour: "numeric", minute: "2-digit" });
  }

  function getInitial(name, fallback) {
    var value = String(name || "").trim();
    return value ? value.charAt(0).toUpperCase() : fallback;
  }

  function render(data) {
    var oldScroll = messages.scrollHeight - messages.scrollTop - messages.clientHeight;
    var html = "";

    if (!data.length) {
      html = '<div class="misfits-chat-empty">No messages yet. Start the conversation.</div>';
    } else {
      data.forEach(function (item) {
        var admin = Number(item.is_admin) === 1;
        var isMine = !admin && myGuestId && String(item.guest_id || "") === String(myGuestId);
        var sideClass = isMine ? "is-right" : "is-left";
        var bubbleClass = admin ? "is-admin" : (isMine ? "is-owner" : "is-other");
        var nameClass = admin ? "misfits-chat-name is-admin" : "misfits-chat-name";
        var time = formatChatTime(item.created_at);
        var displayName = admin ? "MISFITS ADMIN" : item.guest_name || "Guest Rider";
        var initial = admin ? "M" : getInitial(displayName, "G");

        html += '<div class="misfits-chat-message-row ' + sideClass + '">';

        if (!isMine) {
          html += '<div class="misfits-chat-avatar ' + (admin ? "is-admin" : "is-other") + '">' + escapeHtml(initial) + '</div>';
        }

        html += '<div class="misfits-chat-message-wrap">';

        if (!isMine) {
          html += '<div class="' + nameClass + '">' + escapeHtml(displayName) + '</div>';
        }

        html += '<div class="misfits-chat-bubble ' + bubbleClass + '">';
        html += '<p class="misfits-chat-message-text">' + escapeHtml(item.message) + '</p>';
        html += '</div>';

        if (time) {
          html += '<div class="misfits-chat-time ' + (sideClass === "is-left" ? "is-left" : "is-right") + '">' + escapeHtml(time) + '</div>';
        }

        html += '</div></div>';
      });
    }

    messages.innerHTML = html;
    if (oldScroll < 80) messages.scrollTop = messages.scrollHeight;
  }

  function loadMessages(markRead) {
    var params = [];
    if (myGuestId) params.push("guest_id=" + encodeURIComponent(myGuestId));
    if (markRead) params.push("mark_read=1");

    fetch(messagesUrl + "?" + params.join("&"), {
      headers: { Accept: "application/json" }
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (result) {
        if (!result.success) return;

        if (result.guest_id) {
          myGuestId = String(result.guest_id);
          localStorage.setItem("misfits_chat_guest_id", myGuestId);
        }

        render(result.data || []);
        updateCount(markRead ? 0 : result.count);
      })
      .catch(function () {
        if (open) setStatus("Unable to load chat messages.", true);
      });
  }

  function setOpen(value) {
    open = value;
    root.classList.toggle("is-open", value);
    toggle.setAttribute("aria-expanded", value ? "true" : "false");

    if (value) {
      loadMessages(true);
      if (!timer) timer = setInterval(function () { loadMessages(false); }, 4000);
      setTimeout(function () { messageInput.focus(); }, 50);
    } else if (timer) {
      clearInterval(timer);
      timer = null;
    }
  }

  function send() {
    var guestName = nameInput.value.trim() || "Guest Rider";
    var message = messageInput.value.trim();
    if (!message) {
      setStatus("Please enter a message.", true);
      return;
    }

    sendButton.disabled = true;
    setStatus("Sending...");

    var body = new URLSearchParams();
    body.set("guest_id", myGuestId);
    body.set("guest_name", guestName);
    body.set("message", message);

    fetch(sendUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        Accept: "application/json"
      },
      body: body.toString()
    })
      .then(function (response) {
        return response.json().then(function (result) {
          return { ok: response.ok, result: result };
        });
      })
      .then(function (response) {
        if (!response.result.success) {
          throw new Error(response.result.message || "Unable to send message.");
        }

        if (response.result.guest_id) {
          myGuestId = String(response.result.guest_id);
          localStorage.setItem("misfits_chat_guest_id", myGuestId);
        }

        localStorage.setItem("misfits_chat_name", guestName);
        messageInput.value = "";
        updateSendButton();
        setStatus("Message sent.");
        loadMessages(true);
      })
      .catch(function (error) {
        setStatus(error.message, true);
      })
      .finally(function () {
        sendButton.disabled = false;
      });
  }

  toggle.addEventListener("click", function () { setOpen(!open); });
  close.addEventListener("click", function () { setOpen(false); });
  sendButton.addEventListener("click", send);
  messageInput.addEventListener("input", updateSendButton);
  messageInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter" && !event.shiftKey) {
      event.preventDefault();
      send();
    }
  });

  updateSendButton();
  loadMessages(false);
})();
</script>