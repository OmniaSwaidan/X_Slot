<!-- resources/views/components/basement/organisms/chatbot.blade.php -->
<template x-if="isChatbotOpen">
    <div
        class="basement-contacts__user-container bm-grid bm-cursor-pointer bm-grid-cols-12 bm-items-center bm-gap-x-2 bm-border-t bm-border-gray-300 bm-px-2 bm-py-3 bm-transition hover:bm-bg-gray-100"
        x-on:click="isContactOpened = false; isMessageBoxOpened = true;"
    >
        <div class="bm-relative bm-col-span-2">
            <img class="bm-rounded-full" alt="Chatbot" src="/path-to-your-chatbot-avatar.png" />
            <span class="basement-contacts__user-online-indicator bm-absolute bm-right-0 bm-top-0 bm-h-3 bm-w-3 bm-rounded-full bm-bg-green-400"></span>
        </div>

        <div class="bm-col-span-10">
            <div class="bm-grid bm-grid-cols-4">
                <h4 class="bm-col-span-3 bm-truncate bm-text-sm bm-font-bold bm-text-gray-900">
                    Chatbot
                </h4>
            </div>

            <div class="bm-grid bm-grid-cols-4">
                <p class="bm-col-span-3 bm-truncate bm-text-sm">
                    <span>How can I assist you today?</span>
                </p>
            </div>
        </div>
    </div>
</template>

<template x-if="isMessageBoxOpened">
    <div class="bm-h-full bm-flex bm-flex-col bm-justify-between bm-bg-white bm-shadow-lg bm-p-4">
        <h1>Chatbot</h1>
        <div id="chat-log" class="bm-flex-grow bm-overflow-y-auto bm-border bm-p-2">
            <!-- Chat log messages will be appended here -->
            <template x-for="log in chatLog" :key="log.id">
                <p x-text="log"></p>
            </template>
        </div>

        <form x-on:submit.prevent="sendMessage" class="bm-mt-4 bm-flex bm-items-center">
            <input
                type="text"
                id="message"
                placeholder="Type a message..."
                class="bm-flex-grow bm-p-2 bm-border bm-rounded"
                x-model="message"
            >
            <button type="submit" class="bm-ml-2 bm-p-2 bm-bg-blue-500 bm-text-white bm-rounded">Send</button>
        </form>
    </div>
</template>

{{-- <script>
    function chatbot() {
        return {
            isChatbotOpen: false,
            isContactOpened: false,
            isMessageBoxOpened: false,
            message: '',
            chatLog: [],
            sendMessage() {
                if (this.message.trim() !== '') {
                    const message = this.message.trim();
                    fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.chatLog.push(`You: ${message}`);
                        this.chatLog.push(`Bot: ${data.response}`);
                        this.message = '';
                        this.$nextTick(() => {
                            const chatLogDiv = document.getElementById('chat-log');
                            chatLogDiv.scrollTop = chatLogDiv.scrollHeight;
                        });
                    })
                    .catch(error => console.error(error));
                }
            }
        };
    }
</script> --}}
<script>
    function chatbot() {
        return {
            isChatbotOpen: false,
            isContactOpened: false,
            isMessageBoxOpened: false,
            message: '',
            chatLog: [],
            toggleChatbot() {
                this.isChatbotOpen = !this.isChatbotOpen;
                this.isMessageBoxOpened = this.isChatbotOpen;
            },
            sendMessage() {
                if (this.message.trim() !== '') {
                    const message = this.message.trim();
                    fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.chatLog.push(`You: ${message}`);
                        this.chatLog.push(`Bot: ${data.response}`);
                        this.message = '';
                        this.$nextTick(() => {
                            const chatLogDiv = document.getElementById('chat-log');
                            chatLogDiv.scrollTop = chatLogDiv.scrollHeight;
                        });
                    });
                    // .catch(error => console.error(error));
                }
            }
        };
    }
</script>
