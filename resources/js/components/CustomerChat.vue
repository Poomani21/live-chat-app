<!-- resources/js/components/CustomerChat.vue -->
<template>
    <div>
        <div v-for="message in messages" :key="message.id">
            <strong>{{ message.sender }}:</strong> {{ message.text }}
        </div>

        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message..." />
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: '',
        };
    },
    mounted() {
        // Fetch initial messages from the server
        this.fetchMessages();
    },
    methods: {
        fetchMessages() {
            // Assuming you have an API endpoint to get messages
            axios.get('/api/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        },
        sendMessage() {
            // Assuming you have an API endpoint to send messages
            axios.post('/api/messages', {
                sender: 'customer',
                text: this.newMessage,
            })
            .then(response => {
                // Update messages array with the new message from the server response
                this.messages.push(response.data);
                // Clear the input field
                this.newMessage = '';
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        },
    },
};
</script>
