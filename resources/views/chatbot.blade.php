<!-- Chatbot Widget UI -->
<style>
    :root {
        --chatbot-primary: #279ED6;     /* Matching Avoinex blue */
        --chatbot-secondary: #1C7DAA;
        --chatbot-bg: #ffffff;
        --chatbot-text: #212529;
        --chatbot-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        --chatbot-font: 'Poppins', sans-serif;
    }

    /* Floating Widget Wrapper */
    .chatbot-widget-wrapper {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
    }

    @media (max-width: 768px) {
        .chatbot-widget-wrapper {
            bottom: 20px;
            right: 20px;
        }
    }

    /* Vanessa Speech Bubble */
    .vanessa-speech-bubble {
        position: absolute;
        bottom: 85px;
        right: -5px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 24px rgba(0,0,0,0.1);
        border-radius: 16px;
        padding: 8px 14px;
        font-family: var(--chatbot-font);
        font-size: 12.5px;
        font-weight: 500;
        color: #2b3a4a;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        
        /* Posisi awal sembunyi: mengecil tepat di ekor bubble (tengah atas Vanessa) */
        transform: translateY(15px) scale(0);
        transform-origin: calc(100% - 37px) 100%; 
        
        transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        pointer-events: none;
        z-index: 10000;
    }

    /* Ujung tajam agak belok */
    .vanessa-speech-bubble::after {
        content: '';
        position: absolute;
        bottom: -7px;
        right: 30px;
        width: 14px;
        height: 14px;
        background: #ffffff;
        border-right: 1px solid rgba(0,0,0,0.06);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        border-bottom-right-radius: 4px;
        transform: rotate(45deg);
    }

    .vanessa-speech-bubble.show {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        /* Trigger animasi bounce */
        animation: bubbleBounce 0.65s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes bubbleBounce {
        0% { opacity: 0; transform: translateY(20px) scale(0.2); }
        50% { opacity: 1; transform: translateY(-8px) scale(1.08); }
        75% { transform: translateY(2px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .vanessa-speech-bubble.hide-bounce {
        animation: bubbleBounceOut 0.4s cubic-bezier(0.600, -0.280, 0.735, 0.045) forwards;
    }

    @keyframes bubbleBounceOut {
        0% { opacity: 1; transform: translateY(0) scale(1); }
        30% { transform: translateY(-10px) scale(1.05); }
        100% { opacity: 0; transform: translateY(15px) scale(0); }
    }

    .vanessa-cursor {
        display: inline-block;
        width: 2px;
        height: 14px;
        background-color: #2b3a4a;
        vertical-align: text-bottom;
        margin-left: 2px;
        animation: blink 1s step-end infinite;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }

    /* Floating Widget Button */
    .chatbot-widget-btn {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: transparent;
        box-shadow: var(--chatbot-shadow);
        cursor: grab;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        overflow: hidden;
    }

    /* Responsive Widget Size */
    @media (max-width: 768px) {
        .chatbot-widget-btn {
            width: 68px;
            height: 68px;
        }
    }

    .chatbot-widget-btn:hover {
        transform: scale(1.05); /* Sedikit dikurangi agar drag lebih mulus */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    
    .chatbot-widget-btn:active {
        cursor: grabbing;
    }

    .chatbot-widget-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Notification Badge */
    .chatbot-badge {
        position: absolute;
        top: 0;
        right: 0;
        width: 15px;
        height: 15px;
        background-color: #ff3b30;
        border-radius: 50%;
        border: 2px solid #fff;
        display: none; /* Shown dynamically */
    }

    /* Chat Window */
    .chatbot-window {
        position: fixed;
        bottom: 110px; /* Disesuaikan dengan naiknya widget */
        right: 30px;
        width: 350px;
        max-height: 500px;
        background-color: var(--chatbot-bg);
        border-radius: 16px;
        box-shadow: var(--chatbot-shadow);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .chatbot-window.active {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }

    @media (max-width: 768px) {
        .chatbot-window {
            width: calc(100% - 30px);
            right: 15px;
            bottom: 90px;
            height: calc(100vh - 170px);
            max-height: 600px;
        }
    }

    /* Header */
    .chatbot-header {
        background: linear-gradient(135deg, var(--chatbot-primary) 0%, var(--chatbot-secondary) 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: var(--chatbot-font);
    }

    .chatbot-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbot-header-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.8);
        overflow: hidden;
        background-color: #fff;
    }

    .chatbot-header-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .chatbot-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.2;
    }

    .chatbot-status {
        margin: 0;
        font-size: 12px;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .chatbot-status::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #4cd964;
        border-radius: 50%;
        box-shadow: 0 0 5px #4cd964;
    }

    .chatbot-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
        padding: 0;
        line-height: 1;
    }

    .chatbot-close:hover {
        opacity: 1;
    }

    /* Body / Messages Area */
    .chatbot-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #f7f9fc;
        font-family: var(--chatbot-font);
        scroll-behavior: smooth;
        height: 350px;
    }

    .chat-msg {
        max-width: 85%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
        animation: chatMsgFade 0.3s ease forwards;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    @keyframes chatMsgFade {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chat-msg.bot {
        align-self: flex-start;
        background-color: #fff;
        color: var(--chatbot-text);
        border-bottom-left-radius: 4px;
    }

    .chat-msg.user {
        align-self: flex-end;
        background-color: var(--chatbot-primary);
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    /* Typing Indicator */
    .chatbot-typing {
        display: none;
        align-self: flex-start;
        background-color: #fff;
        padding: 12px 16px;
        border-radius: 16px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .chatbot-typing.active {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .dot {
        width: 6px;
        height: 6px;
        background-color: #a0aec0;
        border-radius: 50%;
        animation: typingDot 1.4s infinite ease-in-out both;
    }
    .dot:nth-child(1) { animation-delay: -0.32s; }
    .dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes typingDot {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }

    /* Footer / Input Area */
    .chatbot-footer {
        padding: 15px;
        background-color: #fff;
        border-top: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chatbot-input {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 14px;
        font-family: var(--chatbot-font);
        outline: none;
        transition: border-color 0.2s;
    }
    
    .chatbot-input:focus {
        border-color: var(--chatbot-primary);
    }

    .chatbot-send {
        background-color: var(--chatbot-primary);
        color: #fff;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.2s;
        /* prevent double tap zoom on ios */
        touch-action: manipulation; 
    }

    .chatbot-send:hover {
        background-color: var(--chatbot-secondary);
        transform: scale(1.05);
    }

    .chatbot-send:disabled {
        background-color: #cbd5e0;
        cursor: not-allowed;
        transform: none;
    }
    
    .chatbot-send svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
        margin-left: -2px; /* adjust for optical balance */
    }
    
    /* Hide widget when printing */
    @media print {
        .chatbot-widget-btn, .chatbot-window {
            display: none !important;
        }
    }
</style>

<!-- Widget Wrapper -->
<div class="chatbot-widget-wrapper" id="chatbotWidgetWrapper">
    <!-- Vanessa Speech Bubble -->
    <div class="vanessa-speech-bubble" id="vanessaSpeechBubble">
        <span id="vanessaSpeechText"></span><span class="vanessa-cursor" id="vanessaCursor"></span>
    </div>

    <!-- Widget Button -->
    <div class="chatbot-widget-btn" id="chatbotWidgetBtn" aria-label="Open AI Assistant">
        <div class="chatbot-badge" id="chatbotBadge"></div>
        <!-- Preload images to avoid flickering -->
        <link rel="preload" href="{{ asset('images/vanessa.png') }}" as="image">
        <link rel="preload" href="{{ asset('images/vanessa02.png') }}" as="image">
        <!-- Main avatar image for the widget button -->
        <img src="{{ asset('images/vanessa.png') }}" alt="Vanessa Assistant" id="chatbotAvatarBtn">
    </div>
</div>

<!-- Chat Window -->
<div class="chatbot-window" id="chatbotWindow">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-header-avatar">
                <!-- Avatar image inside chat header -->
                <img src="{{ asset('images/vanessa.png') }}" alt="Vanessa" id="chatbotAvatarHeader">
            </div>
            <div>
                <h3 class="chatbot-title">Vanessa</h3>
                <p class="chatbot-status" id="chatbotStatus">Avoinex Assistant</p>
            </div>
        </div>
        <button class="chatbot-close" id="chatbotCloseBtn" aria-label="Close Chat">&times;</button>
    </div>
    
    <div class="chatbot-body" id="chatbotBody">
        <div class="chat-msg bot">Halo! Saya Vanessa, asisten virtual Avoinex Airlines. Ada yang bisa saya bantu untuk penerbangan atau perjalanan Anda hari ini?</div>
        <!-- Typing indicator -->
        <div class="chatbot-typing" id="chatbotTyping">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <div class="chatbot-footer">
        <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Tulis pesan ke Vanessa..." autocomplete="off">
        <button class="chatbot-send" id="chatbotSendBtn" aria-label="Send Message" disabled>
            <svg viewBox="0 0 24 24">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
            </svg>
        </button>
    </div>
</div>

<!-- Chatbot Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- State Machine & Variables ---
        const STATES = {
            IDLE: 'IDLE',
            LISTENING: 'LISTENING',
            PROCESSING: 'PROCESSING',
            RESPONDING: 'RESPONDING',
            ERROR: 'ERROR',
            OFFLINE: 'OFFLINE'
        };
        
        let currentState = STATES.IDLE;
        let isOpen = false;
        
        // DOM Elements
        const widgetWrapper = document.getElementById('chatbotWidgetWrapper');
        const widgetBtn = document.getElementById('chatbotWidgetBtn');
        const chatWindow = document.getElementById('chatbotWindow');
        
        const closeBtn = document.getElementById('chatbotCloseBtn');
        const chatBody = document.getElementById('chatbotBody');
        const inputField = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSendBtn');
        const typingIndicator = document.getElementById('chatbotTyping');
        const avatarBtn = document.getElementById('chatbotAvatarBtn');
        const avatarHeader = document.getElementById('chatbotAvatarHeader');
        
        // Input empty handling
        inputField.addEventListener('input', function() {
             sendBtn.disabled = this.value.trim() === '';
        });

        // --- Photo Loop Animation (Blink) ---
        const frame1 = "{{ asset('images/vanessa.png') }}";
        const frame2 = "{{ asset('images/vanessa02.png') }}";
        const frames = [frame1, frame2];
        let avatarIndex = 0;
        
        // Loop runs forever, switching expression every 1500ms
        setInterval(() => {
            avatarIndex = (avatarIndex + 1) % frames.length;
            const currentFrame = frames[avatarIndex];
            
            // Only update DOM if they are different to save CPU (browser caches image)
            if(avatarBtn.src !== currentFrame) {
                avatarBtn.src = currentFrame;
                avatarHeader.src = currentFrame;
            }
        }, 1500);

        // --- Interaction Logic ---
        
        // --- Drag Functionality ---
        let isDragging = false;
        let dragThreshold = 5;
        let startX, startY, initialX, initialY;
        
        // Restore position
        const savedPos = localStorage.getItem('avoinex_vanessa_pos');
        if (savedPos) {
            try {
                const pos = JSON.parse(savedPos);
                widgetWrapper.style.bottom = 'auto';
                widgetWrapper.style.right = 'auto';
                widgetWrapper.style.left = pos.left;
                widgetWrapper.style.top = pos.top;
            } catch(e) {}
        }

        function dragStart(e) {
            if (e.target.closest('#chatbotBadge') || e.target.closest('button')) return;
            
            if (e.type === "touchstart") {
                initialX = e.touches[0].clientX;
                initialY = e.touches[0].clientY;
            } else {
                initialX = e.clientX;
                initialY = e.clientY;
            }
            
            const rect = widgetWrapper.getBoundingClientRect();
            startX = rect.left;
            startY = rect.top;
            
            isDragging = false;
            widgetWrapper.style.transition = 'none'; // Disable transition for smooth dragging
            
            document.addEventListener('mousemove', drag);
            document.addEventListener('touchmove', drag, {passive: false});
            document.addEventListener('mouseup', dragEnd);
            document.addEventListener('touchend', dragEnd);
        }

        function drag(e) {
            let currentX, currentY;
            if (e.type === "touchmove") {
                currentX = e.touches[0].clientX;
                currentY = e.touches[0].clientY;
            } else {
                currentX = e.clientX;
                currentY = e.clientY;
            }

            const dx = currentX - initialX;
            const dy = currentY - initialY;

            if (Math.abs(dx) > dragThreshold || Math.abs(dy) > dragThreshold) {
                isDragging = true;
                if(e.type === "touchmove") e.preventDefault();
                
                widgetWrapper.style.bottom = 'auto';
                widgetWrapper.style.right = 'auto';
                
                let newLeft = startX + dx;
                let newTop = startY + dy;
                
                // Bounds keeping
                const maxX = window.innerWidth - widgetWrapper.offsetWidth;
                const maxY = window.innerHeight - widgetWrapper.offsetHeight;
                newLeft = Math.max(0, Math.min(newLeft, maxX));
                newTop = Math.max(0, Math.min(newTop, maxY));

                widgetWrapper.style.left = newLeft + 'px';
                widgetWrapper.style.top = newTop + 'px';
                
                // Keep window near the button
                if (isOpen) {
                    if (newLeft > window.innerWidth / 2) {
                        chatWindow.style.right = (window.innerWidth - newLeft - widgetBtn.offsetWidth) + 'px';
                        chatWindow.style.left = 'auto';
                    } else {
                        chatWindow.style.left = newLeft + 'px';
                        chatWindow.style.right = 'auto';
                    }
                    if (newTop > window.innerHeight / 2) {
                        chatWindow.style.bottom = (window.innerHeight - newTop + 10) + 'px';
                        chatWindow.style.top = 'auto';
                    } else {
                        chatWindow.style.top = (newTop + widgetBtn.offsetHeight + 10) + 'px';
                        chatWindow.style.bottom = 'auto';
                    }
                }
            }
        }

        function dragEnd(e) {
            widgetWrapper.style.transition = 'none';
            document.removeEventListener('mousemove', drag);
            document.removeEventListener('touchmove', drag);
            document.removeEventListener('mouseup', dragEnd);
            document.removeEventListener('touchend', dragEnd);
            
            if (isDragging) {
                localStorage.setItem('avoinex_vanessa_pos', JSON.stringify({
                    left: widgetWrapper.style.left,
                    top: widgetWrapper.style.top
                }));
            }
        }

        widgetBtn.addEventListener('mousedown', dragStart);
        widgetBtn.addEventListener('touchstart', dragStart, {passive: true});

        // Toggle Chat Window
        widgetBtn.addEventListener('click', (e) => {
            if(isDragging) {
                e.preventDefault();
                // isDragging direset saat dragStart, jadi biarkan false setelah delay
                setTimeout(() => isDragging = false, 50);
                return;
            }
            if(!isOpen) openChat();
            else closeChat();
        });

        
        closeBtn.addEventListener('click', closeChat);
        
        // Close chat when clicking outside the chat window and widget
        document.addEventListener('click', (e) => {
            if (isOpen && !chatWindow.contains(e.target) && !widgetBtn.contains(e.target)) {
                closeChat();
            }
        });
        
        function openChat() {
            isOpen = true;
            chatWindow.classList.add('active');
            
            // Adjust chat position relative to custom widget placement
            const savedPos = localStorage.getItem('avoinex_vanessa_pos');
            if (savedPos) {
                 const rect = widgetWrapper.getBoundingClientRect();
                 const newLeft = rect.left;
                 const newTop = rect.top;
                 if (newLeft > window.innerWidth / 2) {
                     chatWindow.style.right = (window.innerWidth - newLeft - widgetWrapper.offsetWidth) + 'px';
                     chatWindow.style.left = 'auto';
                 } else {
                     chatWindow.style.left = newLeft + 'px';
                     chatWindow.style.right = 'auto';
                 }
                 if (newTop > window.innerHeight / 2) {
                     chatWindow.style.bottom = (window.innerHeight - newTop + 10) + 'px';
                     chatWindow.style.top = 'auto';
                 } else {
                     chatWindow.style.top = (newTop + widgetWrapper.offsetHeight + 10) + 'px';
                     chatWindow.style.bottom = 'auto';
                 }
            }
            
            inputField.focus();
        }
        
        function closeChat() {
            isOpen = false;
            chatWindow.classList.remove('active');
        }
        
        // Input handling
        inputField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSend();
            }
            if (currentState === STATES.IDLE) {
                changeState(STATES.LISTENING);
            }
        });
        
        sendBtn.addEventListener('click', handleSend);
        
        function handleSend() {
            const message = inputField.value.trim();
            if (message === '' || currentState === STATES.PROCESSING) return;
            
            // 1. Add User Message
            appendMessage(message, 'user');
            inputField.value = '';
            inputField.disabled = true;
            sendBtn.disabled = true;
            
            // 2. State -> Processing
            changeState(STATES.PROCESSING);
            
            // 3. Send to API with max 3 retries
            sendToAPI(message, 3);
        }
        
        function appendMessage(text, sender) {
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('chat-msg', sender);
            // Replace new lines with <br> for formatting
            msgDiv.innerHTML = escapeHtml(text).replace(/\n/g, '<br>'); 
            
            // Insert before typing indicator
            chatBody.insertBefore(msgDiv, typingIndicator);
            scrollToBottom();
        }

        // Basic XSS protection
        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
         }
        
        function scrollToBottom() {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
        
        function changeState(newState) {
            currentState = newState;
            
            if (newState === STATES.PROCESSING) {
                typingIndicator.classList.add('active');
                scrollToBottom();
            } else {
                typingIndicator.classList.remove('active');
            }
            
            if (newState === STATES.IDLE || newState === STATES.ERROR) {
                inputField.disabled = false;
                if(inputField.value.trim().length > 0) {
                     sendBtn.disabled = false;
                }
                if(isOpen) inputField.focus();
            }
        }
        
        // --- API Integration ---
        async function sendToAPI(message, retriesLeft) {
            try {
                // Get CSRF token from page meta tag safely
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
                
                const response = await fetch('{{ url('/api/chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ message: message })
                });
                
                if (!response.ok) throw new Error('API Error: ' + response.status);
                
                const data = await response.json();
                
                // Simulate slight delay for natural feel
                setTimeout(() => {
                    changeState(STATES.RESPONDING);
                    appendMessage(data.reply, 'bot');
                    changeState(STATES.IDLE);
                }, 600);
                
            } catch (error) {
                console.error("Chatbot Error:", error);
                
                if (retriesLeft > 0) {
                    console.warn(`Retrying... (${retriesLeft} attempts left)`);
                    setTimeout(() => sendToAPI(message, retriesLeft - 1), 1000);
                } else {
                    changeState(STATES.ERROR);
                    appendMessage("Maaf, terjadi gangguan koneksi. Silakan coba lagi nanti.", 'bot');
                }
            }
        }
        // --- Vanessa Speech Bubble Animation ---
        const vanessaPhrases = [
            "Hai! Butuh bantuan cari tiket pesawat? ✈️",
            "Ada promo penerbangan menarik hari ini! ✨",
            "Halo, aku Vanessa. Mau terbang ke mana? 🌍",
            "Punya rencana liburan? Sini aku bantu! 🏖️",
            "Klik aku ya kalau ada pertanyaan! 😊",
            "Halo, aku Vanessa. Mau terbang ke mana? 🌍",
            "Dunia itu terlalu luas kalau cuma dilihat dari jendela rumah. Yuk, terbang! ☁️",
            "Cari tiket pesawat nggak perlu pusing, biarkan aku jadi kompasmu. 🧭",
            "Ada cerita baru yang menunggumu di balik awan. Siap berangkat? ✨",
            "Bentangkan sayapmu, biarkan aku yang carikan rute terbaiknya. 🕊️",
            "Jarak bukan masalah, asalkan tiket murah sudah di tangan! 🗺️",
            "Psst! Ada kursi kosong dengan harga miring, lho. Cek yuk? 📉",
            "Jangan cuma disimpan di wishlist, nanti keburu diambil orang! 🏃‍♂️",
            "Promo hari ini manis banget, semanis kenangan liburanmu nanti. 🍯",
            "Siap-siap packing! Harga tiket ke destinasi impianmu lagi terjun bebas. 📉",
            "Kerja terus, liburannya kapan? Sini aku bantu cari tiket pelarian! 🏃‍♀️",
            "Lagi pengen 'healing' atau emang mau kabur dari cucian piring? 🌊",
            "Beli tiket sekarang, bahagianya sampai tahun depan! 😊",
            "Dompet aman, hati senang, terbang pun tenang. Tanya aku aja! 💳",
            "Cari rute tercepat atau harga termurah? Aku punya keduanya. ⚡",
            "Vanessa di sini! Siap buat rencana perjalananmu jadi lebih simpel. 📋",
            "Input destinasi tujuanmu, dan biarkan aku bekerja untukmu. 🔍",
            "Rindu itu berat, biar ongkos kirim dirimu aja yang aku ringankan. ✨",
            "Setiap tiket adalah awal dari sebuah cerita baru. Mari tulis ceritamu! 📖",
            "Awan tidak pernah memihak, tapi aku memihak dompetmu. Yuk, terbang murah! ☁️",
            "Jangan biarkan paspormu kesepian. Beri dia stempel baru hari ini! 🛂",
            "Menabung kenangan jauh lebih berharga daripada sekadar menabung barang. 📸",
            "Status: Ready for Take-off. Masukkan destinasi impianmu di sini! 🛫",
            "Gak perlu turbulence dalam mencari harga. Aku carikan yang paling stabil. 📉",
            "Lupakan delay dalam rencana. Eksekusi liburanmu sekarang juga! ⚡",
            "Mode hemat: ON. Aku sudah siapkan daftar kursi paling ekonomis. 💸",
            "Satu klik menuju boarding gate. Mau ke mana kita hari ini? 🎫",
            "Self-reward paling ampuh? Ya beli tiket pesawat, lah! 💅",
            "Gak usah nunggu 'kapan-kapan', nanti malah jadi 'nggak jadi-jadi'. 🏃‍♂️",
            "Capek scroll doang? Mending langsung landing di tempat impian! 🏝️",
            "Vanessa punya kunci gerbang dunia, kamu tinggal pilih mau lewat mana. 🔑",
            "Hidup cuma sekali, sayang kalau cuma di satu kota terus. 🌍",
            "Jangan biarkan FOMO mengalahkan budget. Aku bantu carikan yang pas! 💰",
            "Koleksi foto liburan lebih keren daripada koleksi drama Korea. ✈️",
            "Cuma butuh 3 detik buat scroll IG, tapi butuh waktu lama buat liburan. Yuk, percepat! ⚡",
            "Tiket promo itu kayak jodoh, datangnya tiba-tiba. Jangan sampai kehabisan! 🏃",
            "Mimpi ke luar negeri itu gratis, tapi tiketnya harus dibeli. Sini aku bantu urus! 💳"
        ];
        
        const speechBubble = document.getElementById('vanessaSpeechBubble');
        const speechText = document.getElementById('vanessaSpeechText');
        let bubbleTimer;
        let typeWriterTimeout;
        
        function hideVanessaBubble() {
            if(speechBubble && speechBubble.classList.contains('show')) {
                clearTimeout(typeWriterTimeout);
                speechBubble.classList.add('hide-bounce');
                setTimeout(() => {
                    speechBubble.classList.remove('show');
                    speechBubble.classList.remove('hide-bounce');
                    speechText.innerHTML = ''; 
                }, 400); // durasi animasi bounce out
            }
        }

        function typeWriter(text, i, cb) {
            if (i < text.length) {
                speechText.innerHTML = text.substring(0, i+1);
                let speed = Math.random() * 40 + 40; 
                typeWriterTimeout = setTimeout(function() {
                    typeWriter(text, i + 1, cb);
                }, speed);
            } else {
                if(cb) cb();
            }
        }

        function triggerVanessaBubble() {
            if (!speechBubble || !widgetBtn) return;
            if (isOpen || isDragging || widgetBtn.matches(':hover') || speechBubble.classList.contains('show')) {
                return; 
            }
            const randPhrase = vanessaPhrases[Math.floor(Math.random() * vanessaPhrases.length)];
            speechText.innerHTML = '';
            speechBubble.classList.add('show');
            
            clearTimeout(typeWriterTimeout);
            typeWriter(randPhrase, 0, function() {
                setTimeout(hideVanessaBubble, 4500);
            });
        }

        setTimeout(triggerVanessaBubble, 3000);
        setInterval(triggerVanessaBubble, 30000);
        
        // Hide if user interacts
        if(widgetBtn) {
            widgetBtn.addEventListener('mouseenter', hideVanessaBubble);
            widgetBtn.addEventListener('mousedown', hideVanessaBubble);
            widgetBtn.addEventListener('touchstart', hideVanessaBubble, {passive: true});
        }
    });
</script>
